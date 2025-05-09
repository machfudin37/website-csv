<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Imports\PenyakitImport;
use App\Models\DaerahModel;
use App\Models\PenyakitModel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Penyakit',
            'penyakit'  => PenyakitModel::paginate(10),
            'daerah'  => DaerahModel::all(),
        ];

        return view('penyakit.index', $data);
    }
    public function filterdatapenyakit(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $filtersearch = $request->filtersearch;

        $penyakit = PenyakitModel::when($start_date, function ($query) use ($start_date) {
            return $query->whereDate('created_at', '>=', $start_date);
        })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($filtersearch, function ($query) use ($filtersearch) {
                return $query->where(function ($q) use ($filtersearch) {
                    $q->where('nama_pasien', 'like', '%' . $filtersearch . '%')
                        ->orWhere('nik', 'like', '%' . $filtersearch . '%')
                        ->orWhere('tanggal_lahir', 'like', '%' . $filtersearch . '%')
                        ->orWhere('tanggal_berobat', 'like', '%' . $filtersearch . '%')
                        ->orWhere('nohp', 'like', '%' . $filtersearch . '%')
                        ->orWhere('jenis_kelamin', 'like', '%' . $filtersearch . '%')
                        ->orWhere('alamat', 'like', '%' . $filtersearch . '%')
                        ->orWhere('jenis_penyakit', 'like', '%' . $filtersearch . '%')
                        ->orWhere('daerah', 'like', '%' . $filtersearch . '%');
                });
            })
            ->paginate(10);

        return view('penyakit.index', [
            'penyakit' => $penyakit,
            'title' => 'Penyakit',
            'daerah' => DaerahModel::all(),
        ]);
    }
    public function importcsvpenyakit(Request $request)
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

            Excel::import(new PenyakitImport($daerah, $nama_file), public_path('/file_form/' . $namafile));
            Session::flash('message', 'Data Berhasil Diimport!');
            return redirect('penyakit');
        } catch (\Exception $e) {
            Session::flash('error', 'Data Gagal Diimport: ' . $e->getMessage());
            return redirect('penyakit');
        }
    }
    public function exportpdfpenyakit()
    {
        $penyakit = PenyakitModel::all();

        $pdf = PDF::loadview('penyakit.penyakit-pdf', ['penyakit' => $penyakit]);
        return $pdf->download('Penyakit.pdf');
    }
    public function exportpdfdatepenyakit(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $penyakit = PenyakitModel::whereBetween('created_at', [$start_date, $end_date])->get();

        $pdf = PDF::loadview('penyakit.penyakit-pdf', ['penyakit' => $penyakit]);
        return $pdf->download('Penyakit.pdf');
    }
    public function exportpdfsearchpenyakit(Request $request)
    {
        $filtersearch = $request->filtersearch;

        $penyakit = PenyakitModel::where('nama_pasien', 'like', '%' . $filtersearch . '%')
            ->orWhere('nik', 'like', '%' . $filtersearch . '%')
            ->orWhere('tanggal_lahir', 'like', '%' . $filtersearch . '%')
            ->orWhere('tanggal_berobat', 'like', '%' . $filtersearch . '%')
            ->orWhere('nohp', 'like', '%' . $filtersearch . '%')
            ->orWhere('jenis_kelamin', 'like', '%' . $filtersearch . '%')
            ->orWhere('alamat', 'like', '%' . $filtersearch . '%')
            ->orWhere('jenis_penyakit', 'like', '%' . $filtersearch . '%')
            ->orWhere('daerah', 'like', '%' . $filtersearch . '%')
            ->get();

        $pdf = PDF::loadview('penyakit.penyakit-pdf', ['penyakit' => $penyakit]);
        return $pdf->download('Penyakit.pdf');
    }
    // Start Chart
    public function chartjumlahpenyakitperbulan()
    {
        $penyakit = PenyakitModel::selectRaw('MONTH(created_at) as month,Count(*) as count')
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
            foreach ($penyakit as $p) {
                if ($p->month == $i) {
                    $count = $p->count;
                    break;
                }
            }
            array_push($labels, $month);
            array_push($data, $count);
        }
        $datasets = [[
            'label' => 'Jumlah Penyakit',
            'data' => $data,
            'backgroundColor' => $colors
        ]];
        $json_daerah = $this->json_namadaerah();
        $totaldaerah = $this->json_daerah();
        $json_penyakitcakung = $this->json_jenispenyakitcakung();
        $totalpenyakitcakung = $this->json_penyakitcakung();
        $json_penyakitjatinegara = $this->json_jenispenyakitjatinegara();
        $totalpenyakitjatinegara = $this->json_penyakitjatinegara();

        return view('chart.penyakit.index', [
            'title' => 'Chart Penyakit',
            'datasets' => $datasets,
            'labels' => $labels,
            'json_daerah' => $json_daerah,
            'totaldaerah' => $totaldaerah,
            'json_penyakitcakung' => $json_penyakitcakung,
            'totalpenyakitcakung' => $totalpenyakitcakung,
            'json_penyakitjatinegara' => $json_penyakitjatinegara,
            'totalpenyakitjatinegara' => $totalpenyakitjatinegara,
        ]);
    }
    public function json_namadaerah()
    {
        $json = [];
        $query = PenyakitModel::select('daerah')->groupBy('daerah')->get();
        foreach ($query as $row) {
            $json[] = $row->daerah;
        }

        return json_encode($json);
    }

    public function json_daerah()
    {
        $json = [];
        $query = PenyakitModel::select('daerah', DB::raw("COUNT(*) as jml"))->groupBy('daerah')->get();
        foreach ($query as $row) {
            $json[] = ['name' => $row->daerah, 'data' => [$row->jml]];
        }

        return json_encode($json);
    }
    public function json_jenispenyakitcakung()
    {
        $json = [];
        $query = PenyakitModel::select('jenis_penyakit')->where('daerah', 'Jakarta')->groupBy('jenis_penyakit')->get();
        foreach ($query as $row) {
            $json[] = $row->jenis_penyakit;
        }

        return json_encode($json);
    }

    public function json_penyakitcakung()
    {
        $json = [];
        $query = PenyakitModel::select('jenis_penyakit')
            ->where('daerah', 'Jakarta')
            ->get();

        $jenis_penyakit = [];
        $jumlah_penyakit = [];

        foreach ($query as $row) {
            $jenis = explode(',', $row->jenis_penyakit);
            foreach ($jenis as $jenis_p) {
                $jenis_penyakit[] = trim($jenis_p);
            }
        }

        $jenis_penyakit = array_unique($jenis_penyakit);

        foreach ($jenis_penyakit as $jenis) {
            $count = 0;
            foreach ($query as $row) {
                $jenis_arr = explode(',', $row->jenis_penyakit);
                foreach ($jenis_arr as $item) {
                    if (trim($item) === $jenis) {
                        $count++;
                    }
                }
            }
            $json[] = [
                'name' => $jenis,
                'data' => [$count]
            ];
        }

        return json_encode($json);
    }
    public function json_jenispenyakitjatinegara()
    {
        $json = [];
        $query = PenyakitModel::select('jenis_penyakit')->where('daerah', 'Bandung')->groupBy('jenis_penyakit')->get();
        foreach ($query as $row) {
            $json[] = $row->jenis_penyakit;
        }

        return json_encode($json);
    }

    public function json_penyakitjatinegara()
    {
        $json = [];
        $query = PenyakitModel::select('jenis_penyakit')
            ->where('daerah', 'Bandung')
            ->get();

        $jenis_penyakit = [];
        $jumlah_penyakit = [];

        foreach ($query as $row) {
            $jenis = explode(',', $row->jenis_penyakit);
            foreach ($jenis as $jenis_p) {
                $jenis_penyakit[] = trim($jenis_p);
            }
        }

        $jenis_penyakit = array_unique($jenis_penyakit);

        foreach ($jenis_penyakit as $jenis) {
            $count = 0;
            foreach ($query as $row) {
                $jenis_arr = explode(',', $row->jenis_penyakit);
                foreach ($jenis_arr as $item) {
                    if (trim($item) === $jenis) {
                        $count++;
                    }
                }
            }
            $json[] = [
                'name' => $jenis,
                'data' => [$count]
            ];
        }

        return json_encode($json);
    }
    //End Chart
}
