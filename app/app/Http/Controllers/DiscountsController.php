<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Http\Requests\{
    DiscountRequest,
    CupomRequest
};
use App\{
    User,
    Users_discont
};

class DiscountsController extends Controller
{
    private $user = null;
    
    public function index()
    {
        return Discount::all(['name']);
    }

    //método para utilizar o cupom
    public function cupom(CupomRequest $request)
    {
        Users_discont::where('cupom',$request->cupom)->update([
            'updated_at' => date("Y-m-d H:i:s",strtotime("now"))
        ]);

        return response()->json(['Cupom utilizado com sucesso']);
    }

    //método para gerar cupom de desconto
    public function draw(DiscountRequest $request)
    {
        
        //Cadastrando novos usuários
        if(!User::where('email',$request->email)->count()){
            $this->user = User::create($request->all());
        }else{
            $this->user = User::where('email',$request->email)->first();
        }
        $discount = Discount::all()->random();
        $cupom = '';
        $deadline = '';
        //gerando cupom de desconto
        if($discount->name !== 'Tente outra vez'){
            $cupom = strtoupper(
                substr(uniqid(rand(),true),0,6)
            );
            $deadline = date("Y-m-d h:i:s",strtotime("+ 7days"));
            $this->user->discounts()->attach($discount->id,[
                'cupom' => $cupom,
                'deadline' => $deadline,
                'created_at'=>date("Y-m-d H:i:s",strtotime("now"))
            ]);
        }
        return response()->json([
            'discount' => $discount->name,
            'cupom' =>$cupom,
            'deadline'=> $deadline !== '' ? date("d/m/Y H:i:s",strtotime($deadline)): ''
        ]);
    }
}
