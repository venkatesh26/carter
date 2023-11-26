<?php

use Illuminate\Database\Seeder;
use App\Customizer;
use Amcoders\Plugin\zoom\models\Meeting;

class CustomizerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		
	
		$customizers = [
			[
				"id" => 1,
				"key" => "hero",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"hero_right_image\":{\"old_value\":null,\"new_value\":\"uploads\/2020-08-03-5f27e155e25e4.jpg\"},\"hero_right_title\":{\"old_value\":\"Hello Usa The Best 20% off\",\"new_value\":\"Get 20% Off From Special Day\"},\"hero_title\":{\"old_value\":null,\"new_value\":\"Find Awesome Deals in Bangladesh\"},\"hero_des\":{\"old_value\":null,\"new_value\":\"Lists of top restaurants, cafes, pubs and bars in Melbourne, based on trends\"},\"button_title\":{\"old_value\":null,\"new_value\":\"Search\"},\"offer_title\":{\"old_value\":null,\"new_value\":\"Available Offer Right Now\"},\"hero_right_content\":{\"old_value\":null,\"new_value\":\"VALID ON SELECT ITEM\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 2,
				"key" => "header",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"logo\":{\"old_value\":null,\"new_value\":\"uploads\/2020-08-03-5f27e25e2a680.png\"},\"header_pn\":{\"old_value\":null,\"new_value\":\"+825-285-9687\"},\"rider_team_title\":{\"old_value\":null,\"new_value\":\"Join Our Khana Rider Team!\"},\"rider_button_title\":{\"old_value\":null,\"new_value\":\"Apply Now\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 3,
				"key" => "category",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"category_title\":{\"old_value\":null,\"new_value\":\"Browse By Category\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 4,
				"key" => "best_restaurant",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"best_restaurant_title\":{\"old_value\":null,\"new_value\":\"Best Rated Restaurant\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 5,
				"key" => "city_area",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"find_city_title\":{\"old_value\":null,\"new_value\":\"Find us in these cities and many more!\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 6,
				"key" => "featured_resturent",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"featured_resturent_title\":{\"old_value\":null,\"new_value\":\"Featured Restaturents\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 7,
				"key" => "footer",
				"theme_name" => "khana",
				"value" => "{\"settings\":{\"copyright_area\":{\"old_value\":null,\"new_value\":\"\u00a9 Copyright 2020 Amcoders. All rights reserved\"}}}",
				"status" => "1",
				"created_at" => "2021-09-21 05:16:19",
				"updated_at" => "2021-09-21 05:16:19"
			],
			[
				"id" => 8,
				"key" => "food_header",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"logo\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558d066a88f.png\"},\"header_btn_txt\":{\"old_value\":null,\"new_value\":\"SignUp\"}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:10:14",
				"updated_at" => "2021-09-30 10:10:27"
			],
			[
				"id" => 9,
				"key" => "food_hero",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"bg_img\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558d1e3dbb8.png\"},\"hero_title\":{\"old_value\":null,\"new_value\":\"Order breakfast, lunch, and dinner.\"},\"hero_des\":{\"old_value\":null,\"new_value\":\"Lists of top restaurants, cafes, pubs and bars in Melbourne, based on trends.\"},\"hero_btn\":{\"old_value\":null,\"new_value\":\"Find Food\"}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:10:38",
				"updated_at" => "2021-09-30 10:11:01"
			],
			[
				"id" => 10,
				"key" => "food_category",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"category_title\":{\"old_value\":null,\"new_value\":\"Browse By Category\"}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:11:06",
				"updated_at" => "2021-09-30 10:12:41"
			],
			[
				"id" => 11,
				"key" => "featured_restaturents",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"featured_title\":{\"old_value\":null,\"new_value\":\"Featured Restaturents\"},\"featured_des\":{\"old_value\":null,\"new_value\":\"Completely network impactful users whereas next-generation applications engage out thinking via tactical action.\"}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:11:12",
				"updated_at" => "2021-09-30 10:12:41"
			],
			[
				"id" => 12,
				"key" => "location",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"location_title\":{\"old_value\":null,\"new_value\":\"Find us these cities any many more.\"}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:11:33",
				"updated_at" => "2021-09-30 10:12:41"
			],
			[
				"id" => 13,
				"key" => "partnership",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"partnership_title\":{\"old_value\":null,\"new_value\":\"Want to Join Partnrship?\"},\"partnership_left_img\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558d6abd76a.jpg\"},\"partnership_left_title\":{\"old_value\":null,\"new_value\":\"Join As A Delivery Man\"},\"partnership_right_img\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558d84eeab1.jpg\"},\"partnership_right_title\":{\"old_value\":null,\"new_value\":\"Join As A Vendor\"}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:11:49",
				"updated_at" => "2021-09-30 10:12:41"
			],
			[
				"id" => 14,
				"key" => "food_footer",
				"theme_name" => "food",
				"value" => "{\"settings\":{\"footer_contact_title\":{\"old_value\":\"Contact\",\"new_value\":\"Contacts\"},\"footer_address\":{\"old_value\":null,\"new_value\":\"97845 Baker st. 567 Los Angeles - US\"},\"footer_phone_number\":{\"old_value\":null,\"new_value\":\"+94 423-23-221\"},\"footer_email_address\":{\"old_value\":null,\"new_value\":\"info@gmail.com\"},\"footer_right_title\":{\"old_value\":null,\"new_value\":\"Keep In Touch\"},\"footer_social_title\":{\"old_value\":null,\"new_value\":\"FOLLOW US\"},\"footer_payment_img\":{\"old_value\":\"uploads\/2021-09-30-61558df6b0488.svg\",\"new_value\":\"uploads\/2021-09-30-61558e0052fc5.svg\"},\"footer_copyright\":{\"old_value\":null,\"new_value\":\"\u00a9 Food Develop By AMCoders\"}},\"content\":{\"social_first_icon\":{\"first_icon\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558e1b50b43.svg\"}},\"\":{\"first_icon_link\":{\"old_value\":null,\"new_value\":\"#\"},\"second_icon_link\":{\"old_value\":null,\"new_value\":\"#\"},\"third_icon_link\":{\"old_value\":null,\"new_value\":\"#\"},\"four_icon_link\":{\"old_value\":null,\"new_value\":\"#\"}},\"social_second_icon\":{\"second_icon\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558e2433758.svg\"}},\"social_third_icon\":{\"third_icon\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558e2c5c474.svg\"}},\"social_four_icon\":{\"four_icon\":{\"old_value\":null,\"new_value\":\"uploads\/2021-09-30-61558e33de182.svg\"}}}}",
				"status" => "1",
				"created_at" => "2021-09-30 10:13:08",
				"updated_at" => "2021-09-30 10:15:21"
			]
		]; 

		Customizer::insert($customizers);

       
    }
}
