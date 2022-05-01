<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenC;

use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = DB::table('productos')->where('existenciasP','>',0)->get();
        return $productos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $producto = new Producto();
        $producto->nombreP = $request->nombreP;
        $producto->descripcionP = $request->descripcionP;
        $producto->valorP = $request->valorP;
        $producto->existenciasP = $request->existenciasP;
        $producto->save();

        return 'Producto Agregado';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->nombreP = $request->nombreP;
        $producto->descripcionP = $request->descripcionP;
        $producto->valorP = $request->valorP;
        $producto->existenciasP = $request->existenciasP;
        $producto->save();

        return 'Producto Actualizado';
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Producto::destroy($request->id);
        return 'Producto Eliminado';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function compra(Request $request)
    {
        $date = new \DateTime($request->fechacompra);
        $fecha_actual = strtotime(date("d-m-Y",time()));
        $fecha_entrada = strtotime( $date->format('d-m-Y') );

        if($fecha_actual <= $fecha_entrada){
          if( count($request->producto) > 0 ){
            try{
                    $cliente = new Cliente();
                    $cliente->nombreC = $request->nombre;
                    $cliente->emailC = $request->email;
                    $cliente->telefonoC = $request->telefono;
                    $cliente->save();
                    $idcliente=$cliente->idCliente;

                    $ordenC = new OrdenCompra();
                    $ordenC->fechaOrdenC = $request->fechacompra;
                    $ordenC->idCliente = $idcliente;
                    $ordenC->save();
                    $idOrdenC = $ordenC->idOrdenC;

                    $nump=count($request->producto);
                    for($i=0; $i<$nump ;$i++){
                        $detOrdenC = new DetalleOrdenC();
                        $detOrdenC->idOrdenC = $idOrdenC;
                        $detOrdenC->idProducto = $request->producto[$i];
                        $detOrdenC->cantidad = $request->cantidad[$i];
                        $detOrdenC->save();
                    }

                    $total = DB::table('detalleordenesc')
                    ->join('productos', 'productos.idProducto','=', 'detalleordenesc.idProducto')
                    ->select(DB::raw('SUM(cantidad*valorP) as total'))
                    ->where('idOrdenC', '=', $idOrdenC )
                    ->get();

                    $ordenCompra=array('OrdenCompra'=>$idOrdenC,
                                'IdCliente'=>$idcliente,
                                'nombreCliente'=>$request->nombre,
                                'email'=>$request->email,
                                'valorTotal'=>$total[0]->total );

                    return $ordenCompra;

                }catch(Exception $e) {
                    return 'Error agregando Orden de compra: '.  $e->getMessage();
                }

            }else{
              return 'Debe ingresar articulos para comprar';
            }
      }else{
          return 'No puede seleccionar fechas anteriores a la actual. ';
      }


    }
}
