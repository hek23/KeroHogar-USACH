<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Product;
use App\ProductDiscount;
use App\Order;
use App\ProductFormat;
use App\Client;
use App\Town;
use App\Address;

class ProductPricingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function changing_price_is_reflected_on_page()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));

        $oldPrice = 748;
        $newPrice = 848;
        $product = factory(Product::class)->create([
            'name' => 'Parafina',
            'price' => $oldPrice,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);

        $response = $this->get('productos');
        $response->assertStatus(200);
        $response->assertDontSee($newPrice);
        $response->assertSee($oldPrice);

        $response = $this->patch('productos/' . $product->id, [
            'name' => 'Parafina',
            'price' => $newPrice,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        $response->assertStatus(302);
        
        $response = $this->get('productos');
        $response->assertStatus(200);
        $response->assertSee($newPrice);
        $response->assertDontSee($oldPrice);

    }

    /** @test */
    function changing_product_discount_is_reflected_on_page()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));

        $product = create(Product::class, [
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        $oldDiscount = 25;
        $newDiscount = 37;
        $discount = create(ProductDiscount::class, [
            'product_id' => $product->id,
            'discount_per_liter' => $oldDiscount,
            'min_quantity' => 300,
            'max_quantity' => 400,
        ]);

        $response = $this->get('productos/' . $product->id . '/descuentos');
        $response->assertStatus(200);
        $response->assertDontSee($newDiscount);
        $response->assertSee($oldDiscount);

        $response = $this->patch('productos/' . $product->id . '/descuentos/' . $discount->id, [
            'product_id' => $product->id,
            'discount_per_liter' => $newDiscount,
            'min_quantity' => 300,
            'max_quantity' => 400,
        ]);
        $response->assertStatus(302);

        $response = $this->get('productos/' . $product->id . '/descuentos');
        $response->assertStatus(200);
        $response->assertSee($newDiscount);
        $response->assertDontSee($oldDiscount);
    }

    /** @test */
    function compounded_product_price_is_calculted_from_individual_product_and_its_format()
    {
        $product = create(Product::class, [
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        $format = create(ProductFormat::class, [
            'product_id' => $product->id,
            'name' => 'Parafina + bidón',
            'added_price' => 1000,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);
        $address = create(Address::class, [
            'client_id' => create(Client::class, [
                'wholesaler' => false,
            ]),
            'town_id' => get_random(Town::class)->id,
            'address' => 'Calle Marina De Gaete, 781',
        ]);
        $productQuantity = 200; //liters

        $order = create(Order::class, ['address_id' => $address->id]);
        $order->products()->sync([$product->id => ['quantity' => $productQuantity, 'product_format_id' => $format->id]]);
        $order->calculateAmount();
        $order->save();

        $this->assertEquals(($product->price * $productQuantity) + ($format->added_price * (int)($productQuantity / $format->capacity)), $order->amount);
    }

    /** @test */
    function compounded_product_price_is_calculted_from_individual_product_and_its_format_and_discounts()
    {
        $product = create(Product::class, [
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        $format = create(ProductFormat::class, [
            'product_id' => $product->id,
            'name' => 'Parafina + bidón',
            'added_price' => 1000,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);
        $discount = create(ProductDiscount::class,[
            'product_id' => $product->id,
            'discount_per_liter' => 22,
            'min_quantity' => 200,
            'max_quantity' => 300,
        ]);
        $address = create(Address::class, [
            'client_id' => create(Client::class, [
                'wholesaler' => false,
            ]),
            'town_id' => get_random(Town::class)->id,
            'address' => 'Calle Marina De Gaete, 781',
        ]);
        $productQuantity = 200; //liters

        $order = create(Order::class, ['address_id' => $address->id]);
        $order->products()->sync([$product->id => ['quantity' => $productQuantity, 'product_format_id' => $format->id]]);
        $order->calculateAmount();
        $order->save();

        $this->assertEquals((($product->price - $discount->discount_per_liter) * $productQuantity) + ($format->added_price * (int)($productQuantity / $format->capacity)), $order->amount);
    }

    /** @test */
    function wholesaler_client_compounded_product_price_is_calculted_from_wholesaler_price_and_its_format_with_no_additional_discounts()
    {
        $product = create(Product::class, [
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        $format = create(ProductFormat::class, [
            'product_id' => $product->id,
            'name' => 'Parafina + bidón',
            'added_price' => 1000,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);
        $discount = create(ProductDiscount::class,[
            'product_id' => $product->id,
            'discount_per_liter' => 22,
            'min_quantity' => 200,
            'max_quantity' => 300,
        ]);
        $address = create(Address::class, [
            'client_id' => create(Client::class, [
                'wholesaler' => true,
            ]),
            'town_id' => get_random(Town::class)->id,
            'address' => 'Calle Marina De Gaete, 781',
        ]);
        $productQuantity = 200; //liters

        $order = create(Order::class, ['address_id' => $address->id]);
        $order->products()->sync([$product->id => ['quantity' => $productQuantity, 'product_format_id' => $format->id]]);
        $order->calculateAmount();
        $order->save();

        $this->assertEquals(($product->wholesaler_price * $productQuantity) + ($format->added_price * (int)($productQuantity / $format->capacity)), $order->amount);
        $this->assertNotEquals((($product->wholesaler_price - $discount->discount_per_liter) * $productQuantity) + ($format->added_price * (int)($productQuantity / $format->capacity)), $order->amount);
    }
}
