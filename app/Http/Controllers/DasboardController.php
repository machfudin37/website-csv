<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\PenyakitModel;
use App\Models\TanamanModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DasboardController extends Controller
{
    public function index()
    {
        //chart penyakit perbulan
        $penyakit = PenyakitModel::selectRaw('MONTH(created_at) as month,Count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $labelspenyakit = [];
        $datapenyakit = [];
        $colorspenyakit = ['#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6',];
        for ($i = 1; $i < 13; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $count = 0;
            foreach ($penyakit as $p) {
                if ($p->month == $i) {
                    $count = $p->count;
                    break;
                }
            }
            array_push($labelspenyakit, $month);
            array_push($datapenyakit, $count);
        }
        $datasetspenyakit = [[
            'label' => 'Jumlah Penyakit',
            'data' => $datapenyakit,
            'backgroundColor' => $colorspenyakit
        ]];
        //chart tanaman per bulan
        $tanaman = TanamanModel::selectRaw('MONTH(created_at) as month,Count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $labelstanaman = [];
        $datatanaman = [];
        $colorstanaman = ['#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6', '#7eb1d6',];
        for ($i = 1; $i < 13; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $count = 0;
            foreach ($tanaman as $t) {
                if ($t->month == $i) {
                    $count = $t->count;
                    break;
                }
            }
            array_push($labelstanaman, $month);
            array_push($datatanaman, $count);
        }
        $datasetstanaman = [[
            'label' => 'Jumlah Tanaman',
            'data' => $datatanaman,
            'backgroundColor' => $colorstanaman
        ]];
        $alldatatanaman = TanamanModel::all();
        $alldatapenyakit = PenyakitModel::all();
        return view('dasboard.index', [
            'title' => 'Dasboard',
            'datasetspenyakit' => $datasetspenyakit,
            'labelspenyakit' => $labelspenyakit,
            'datasetstanaman' => $datasetstanaman,
            'labelstanaman' => $labelstanaman,
            'alldatatanaman' => $alldatatanaman,
            'alldatapenyakit' => $alldatapenyakit,
        ]);
    }
}
