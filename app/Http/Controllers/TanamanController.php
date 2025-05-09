<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Imports\TanamanImport;
use App\Models\DaerahModel;
use App\Models\TanamanModel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Tanaman',
            'tanaman'  => TanamanModel::oldest()->paginate(10)->withQueryString(),
            'daerah'  => DaerahModel::all(),
        ];

        return view('tanaman.index', $data);
    }
    public function filterdatatanaman(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $filtersearch = $request->filtersearch;

        $tanaman = TanamanModel::when($start_date, function ($query) use ($start_date) {
            return $query->whereDate('created_at', '>=', $start_date);
        })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($filtersearch, function ($query) use ($filtersearch) {
                return $query->where(function ($q) use ($filtersearch) {
                    $q->where('nama_tanaman', 'like', '%' . $filtersearch . '%')
                        ->orWhere('jenis_tanaman', 'like', '%' . $filtersearch . '%')
                        ->orWhere('tanggal_tanam', 'like', '%' . $filtersearch . '%')
                        ->orWhere('kondisi_tanaman', 'like', '%' . $filtersearch . '%')
                        ->orWhere('nohp', 'like', '%' . $filtersearch . '%')
                        ->orWhere('alamat', 'like', '%' . $filtersearch . '%')
                        ->orWhere('daerah', 'like', '%' . $filtersearch . '%');
                });
            })
            ->paginate(10);

        return view('tanaman.index', [
            'tanaman' => $tanaman,
            'title' => 'Tanaman',
            'daerah' => DaerahModel::all(),
        ]);
    }
    public function importcsvtanaman(Request $request)
    {
        try {
            $file = $request->file('file');

            // Pastikan file telah diunggah
            if (!$file) {
                throw new \Exception('File tidak ditemukan.');
            }

            $namafile = $file->getClientOriginalName();
            $file->move('file_form', $namafile);

            // Pastikan file CSV sesuai
            if (!is_file(public_path('/file_form/' . $namafile))) {
                throw new \Exception('Format file tidak sesuai atau file rusak.');
            }

            // Ambil data input nama dan alamat dari request
            $daerah = $request->input('daerah');
            $nama_file = $namafile . '/';

            Excel::import(new TanamanImport($daerah, $nama_file), public_path('/file_form/' . $namafile));
            Session::flash('message', 'Data Berhasil Diimport!');
            return redirect('tanaman');
        } catch (\Exception $e) {
            Session::flash('error', 'Data Gagal Diimport: ' . $e->getMessage());
            return redirect('tanaman');
        }
    }
    public function exportpdftanaman()
    {
        $tanaman = TanamanModel::all();

        $pdf = PDF::loadview('tanaman.tanaman-pdf   ', ['tanaman' => $tanaman]);
        return $pdf->download('Tanaman.pdf');
    }
    public function exportpdfdatetanaman(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $tanaman = TanamanModel::whereBetween('created_at', [$start_date, $end_date])->get();

        $pdf = PDF::loadview('tanaman.tanaman-pdf', ['tanaman' => $tanaman]);
        return $pdf->download('tanaman.pdf');
    }
    public function exportpdfsearchtanaman(Request $request)
    {
        $filtersearch = $request->filtersearch;

        $tanaman = TanamanModel::where('nama_tanaman', 'like', '%' . $filtersearch . '%')
            ->orWhere('jenis_tanaman', 'like', '%' . $filtersearch . '%')
            ->orWhere('tanggal_tanam', 'like', '%' . $filtersearch . '%')
            ->orWhere('kondisi_tanaman', 'like', '%' . $filtersearch . '%')
            ->orWhere('nohp', 'like', '%' . $filtersearch . '%')
            ->orWhere('alamat', 'like', '%' . $filtersearch . '%')
            ->orWhere('daerah', 'like', '%' . $filtersearch . '%')
            ->get();

        $pdf = PDF::loadview('tanaman.tanaman-pdf', ['tanaman' => $tanaman]);
        return $pdf->download('tanaman.pdf');
    }
    // Start Chart
    public function chartjumlahtanamanperbulan()
    {
        $tanaman = TanamanModel::selectRaw('MONTH(created_at) as month,Count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $labels = [];
        $data = [];
        $colors = ['#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6',];
        for ($i = 1; $i < 13; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $count = 0;
            foreach ($tanaman as $t) {
                if ($t->month == $i) {
                    $count = $t->count;
                    break;
                }
            }
            array_push($labels, $month);
            array_push($data, $count);
        }
        $datasets = [[
            'label' => 'Jumlah Tanaman',
            'data' => $data,
            'backgroundColor' => $colors
        ]];
        $json_daerah = $this->json_namadaerah();
        $totaldaerah = $this->json_daerah();
        $json_tanamancakung = $this->json_namatanamancakung();
        $totaltanamancakung = $this->json_tanamancakung();
        $json_tanamanjatinegara = $this->json_namatanamanjatinegara();
        $totaltanamanjatinegara = $this->json_tanamanjatinegara();

        return view('chart.tanaman.index', [
            'title' => 'Chart Tanaman',
            'datasets' => $datasets,
            'labels' => $labels,
            'json_daerah' => $json_daerah,
            'totaldaerah' => $totaldaerah,
            'json_tanamancakung' => $json_tanamancakung,
            'totaltanamancakung' => $totaltanamancakung,
            'json_tanamanjatinegara' => $json_tanamanjatinegara,
            'totaltanamanjatinegara' => $totaltanamanjatinegara,
        ]);
    }
    public function json_namadaerah()
    {
        $json = [];
        $query = TanamanModel::select('daerah')->groupBy('daerah')->get();
        foreach ($query as $row) {
            $json[] = $row->daerah;
        }

        return json_encode($json);
    }

    public function json_daerah()
    {
        $json = [];
        $query = TanamanModel::select('daerah', DB::raw("COUNT(*) as jml"))->groupBy('daerah')->get();
        foreach ($query as $row) {
            $json[] = ['name' => $row->daerah, 'data' => [$row->jml]];
        }

        return json_encode($json);
    }
    public function json_namatanamancakung()
    {
        $json = [];
        $query = TanamanModel::select('nama_tanaman')->where('daerah', 'Jakarta')->groupBy('nama_tanaman')->get();
        foreach ($query as $row) {
            $json[] = $row->nama_tanaman;
        }

        return json_encode($json);
    }

    public function json_tanamancakung()
    {
        $json = [];
        $query = TanamanModel::select('nama_tanaman')
            ->where('daerah', 'Jakarta')
            ->get();

        $nama_tanaman = [];
        $jumlah_tanaman = [];

        foreach ($query as $row) {
            $nama = explode(',', $row->nama_tanaman);
            foreach ($nama as $nama_p) {
                $nama_tanaman[] = trim($nama_p);
            }
        }

        $nama_tanaman = array_unique($nama_tanaman);

        foreach ($nama_tanaman as $nama) {
            $count = 0;
            foreach ($query as $row) {
                $nama_arr = explode(',', $row->nama_tanaman);
                foreach ($nama_arr as $item) {
                    if (trim($item) === $nama) {
                        $count++;
                    }
                }
            }
            $json[] = [
                'name' => $nama,
                'data' => [$count]
            ];
        }

        return json_encode($json);
    }
    public function json_namatanamanjatinegara()
    {
        $json = [];
        $query = TanamanModel::select('nama_tanaman')->where('daerah', 'Bandung')->groupBy('nama_tanaman')->get();
        foreach ($query as $row) {
            $json[] = $row->nama_tanaman;
        }

        return json_encode($json);
    }

    public function json_tanamanjatinegara()
    {
        $json = [];
        $query = TanamanModel::select('nama_tanaman')
            ->where('daerah', 'Bandung')
            ->get();

        $nama_tanaman = [];
        $jumlah_tanaman = [];

        foreach ($query as $row) {
            $nama = explode(',', $row->nama_tanaman);
            foreach ($nama as $nama_p) {
                $nama_tanaman[] = trim($nama_p);
            }
        }

        $nama_tanaman = array_unique($nama_tanaman);

        foreach ($nama_tanaman as $nama) {
            $count = 0;
            foreach ($query as $row) {
                $nama_arr = explode(',', $row->nama_tanaman);
                foreach ($nama_arr as $item) {
                    if (trim($item) === $nama) {
                        $count++;
                    }
                }
            }
            $json[] = [
                'name' => $nama,
                'data' => [$count]
            ];
        }

        return json_encode($json);
    }
    //End Chart
}
