<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Country;
use App\Models\City;
use Ramsey\Uuid\Uuid;

class CityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_city()
    {
        $country = Country::create(["name" => "France"]);
        $country_id =  $country->id;
        $response = $this->postJson("/api/countries/$country_id/cities", [
            "name" => "Paris"
        ]);
        $response->assertCreated();
        $response->assertJson([
            "message" => "City Created Successfully!"
        ]);
    }
    public function test_get_country_related_cities()
    {
        $country = Country::create(["name" => "Ireland"]);
        $country->cities()->create(["name" => "Dublin"]);
        $country_id = $country->id;
        $response = $this->getJson("/api/countries/$country_id/cities");
        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Cities Returned Successfully!"
        ]);
    }
    public function test_get_country_related_city()
    {
        $country = Country::create(["name" => "Iraq"]);
        $country->cities()->create(["name" => "Baghdad"]);
        $country_id = $country->id;
        $city_id = $country->cities()->first()->id;
        $response = $this->withoutExceptionHandling()->getJson("/api/countries/$country_id/cities/$city_id");
        $response->assertOk();
        $response->assertJson([
            "message" => "City Returned Successfully!"
        ]);
    }
    public function test_not_found_country_related_city()
    {
        $country = Country::create(["name" => "Algeria"]);
        $country_id = $country->id;
        $city_id =  (string)Uuid::uuid4();;
        $response = $this->withoutExceptionHandling()->getJson("/api/countries/$country_id/cities/$city_id");
        $response->assertNotFound();
    }
    public function test_update_city()
    {
        $country = Country::create(["name" => "Ukrain"]);
        $country->cities()->create(["name" => "Moscow"]);
        $country_id = $country->id;
        $city_id = $country->cities()->first()->id;
        $response = $this->withoutExceptionHandling()->putJson("/api/countries/$country_id/cities/$city_id", [
            "name" => "Kyiv"
        ]);
        $response->assertOk();
        $response->assertJson([
            "message" => "City Updated Successfully!"
        ]);
    }
    public function test_delete_city()
    {
        $country = Country::create(["name" => "Iran"]);
        $country_id = $country->id;
        $country->cities()->create(["name" => "Tehran"]);
        $city_id = $country->cities()->first()->id;
        $response = $this->withoutExceptionHandling()->deleteJson("/api/countries/$country_id/cities/$city_id");
        $response->assertOk();
        $response->assertJson([
            "message" => "City Deleted Successfully!"
        ]);
    }

}
