<?php

namespace App\Http\Controllers;

use App\Charts\BulanPenyakit;
use Illuminate\Support\Facades\DB;
use App\Models\PenyakitModel;
use Illuminate\Support\Carbon;

class ChartPenyakitController extends Controller
{
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
        $query = PenyakitModel::select('jenis_penyakit')->where('daerah', 'Cakung')->groupBy('jenis_penyakit')->get();
        foreach ($query as $row) {
            $json[] = $row->jenis_penyakit;
        }

        return json_encode($json);
    }

    public function json_penyakitcakung()
    {
        $json = [];
        $query = PenyakitModel::select('jenis_penyakit')
            ->where('daerah', 'Cakung')
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
        $query = PenyakitModel::select('jenis_penyakit')->where('daerah', 'Jatinegara')->groupBy('jenis_penyakit')->get();
        foreach ($query as $row) {
            $json[] = $row->jenis_penyakit;
        }

        return json_encode($json);
    }

    public function json_penyakitjatinegara()
    {
        $json = [];
        $query = PenyakitModel::select('jenis_penyakit')
            ->where('daerah', 'Jatinegara')
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
}
