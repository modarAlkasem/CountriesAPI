<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Country;
use Ramsey\Uuid\Uuid;

class CountryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_country()
    {
        $response = $this->postJson("/api/countries", [
            "name" => "Syria"
        ]);
        $response->assertCreated();
        $response->assertJson([
            "message" => "Country Created Successfully!"
        ]);
    }
    public function test_already_existing_country()
    {
        $country = Country::create(["name" => "Egypt"]);
        $country_name = $country->name;
        $response = $this->postJson("/api/countries", [
            "name" => $country_name
        ]);
        $response->assertUnprocessable();
    }
    public function test_get_all_countries()
    {
        $response = $this->getJson("/api/countries");
        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Countries Returned Successfully!"
        ]);
    }
    public function test_get_country()
    {
        $country = Country::create(["name" => "Turkey"]);
        $country_id =  $country->id;
        $response = $this->withoutExceptionHandling()->getJson("/api/countries/$country_id");
        $response->assertOk();
        $response->assertJson([
            "message" => "Country Returned Successfully!"
        ]);
    }
    public function test_not_fount_country()
    {
        $country_id = (string)Uuid::uuid4();
        $response = $this->withoutExceptionHandling()->getJson("/api/countries/$country_id");
        $response->assertNotFound();
    }
    public function test_update_country()
    {
        $country = Country::create(["name" => "Israel"]);
        $country_id = $country->id;
        $response = $this->withoutExceptionHandling()->putJson("/api/countries/$country_id", [
            "name" => "Palestine"
        ]);
        $response->assertOk();
        $response->assertJson([
            "message" => "Country Updated Successfully!"
        ]);
    }
    public function test_delete_country()
    {
        $country = Country::create(["name" => "Morocco"]);
        $country_id = $country->id;
        $response = $this->withoutExceptionHandling()->deleteJson("/api/countries/$country_id");
        $response->assertOk();
        $response->assertJson([
            "message" => "Country Deleted Successfully!"
        ]);
    }

}
