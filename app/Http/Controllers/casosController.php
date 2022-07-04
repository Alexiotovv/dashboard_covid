<?php

namespace App\Http\Controllers;
use App\Models\casos;
use Illuminate\Http\Request;
use DB;
class casosController extends Controller
{
    public function casos_covid()
    {
        $casos = casos::paginate();
        /*$casos = DB::table('casos_covids')->get();*/

        /*$casos_covid[0] = ['Rafael'];
        $casos_covid[1] = ['Pepe'];
        $casos_covid[2] = ['Monano'];
        $casos_covid[3] = ['Luis'];*/

        return view('cuadro',['casos_covid'=>$casos]);
    }

    public function casos_consolidado_solo(Request $request){
        
        //$period = $request->select('period');
        $period = $request->get('period');
        //$period='todo';
        //$datos = DB::select("call IndicadorCinco_1('$p','$m','$pr')");
        $consolidado = DB::select("call casos_provincia('$period')");
        //$consolidado = DB::select("call prueba_casos");
        return view('consolidadocasos',['casos_covid'=>$consolidado,'period'=>$period]);
        
    }

    public function casos_consolidado_reporte(){
        
        $consolidado = DB::select("call consolidado_casos_reporte");
        $prov_semanas_provincia=DB::select("call consolidado_casos_provincia");
        $casos_distrito=DB::select("call consolidado_casos_distrito");
        $semana_epide=DB::select("call consolidado_casos_semana_epide");
        $positividad=DB::select("call positividad");

        $pos2021=0;
        $neg2021=0;
        $pos2022=0;
        $neg2022=0;
        $pos=0;
        $neg=0;
        $tot=0;
        $per=0;
        foreach ($consolidado as $cc) {
            if ($cc->Distrito=='TOTALES') {
               $pos2021=$cc->Positivos_2021;
               $neg2021=$cc->Negativos_2021;
               $pos2022=$cc->Positivos_2022;
               $neg2022=$cc->Negativos_2022;
            }
        }
        $pos=$pos2021+$pos2022;
        $neg=$neg2021+$neg2022;
        $tot=$pos+$neg;

        $per=($pos/$tot)*100;

        $pos=number_format($pos);
        $neg=number_format($neg);
        $tot=number_format($tot);
        $per=number_format($per,2,'.',',');
    
        return view('cuadro',[
            'positividad'=>$positividad,
            'semana_epide'=>$semana_epide,
            'casos_distrito'=>$casos_distrito,
            'prov_semanas_provincia'=>$prov_semanas_provincia,
            'casos_covid'=>$consolidado,'pos'=>$pos,'neg'=>$neg,'tot'=>$tot,'per'=>$per]);
        
    }

}
