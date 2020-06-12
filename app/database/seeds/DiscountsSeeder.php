<?php

use Illuminate\Database\Seeder;
use App\Discount;

class DiscountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Descontos
        $discounts = array(
            'Tente outra vez',
            '50% de desconto',
            '10% de desconto',
            '80% de desconto',
            '20% de desconto'
        );

        foreach($discounts as $discount)
            Discount::create([
                'name' => $discount
            ]);
        
        
    }
}
