<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Meal;
use App\Models\User;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@foodexpress.com',
            'password' => 'admin123', 
        ]);
        
        $restaurant1 = Restaurant::create([
            'name' => 'Pizza Palace',
            'email' => 'pizza@example.com',
            'password' => 'password123',
            'phone' => '123-456-7890',
            'address' => '123 Main Street',
            'city' => 'New York',
            'description' => 'Best pizza in town!',
            'status' => 'active',
        ]);

        $pizza = Category::create([
            'restaurant_id' => $restaurant1->id,
            'name' => 'Pizza',
            'description' => 'Our delicious pizzas',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $drinks = Category::create([
            'restaurant_id' => $restaurant1->id,
            'name' => 'Drinks',
            'description' => 'Refreshing beverages',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant1->id,
            'category_id' => $pizza->id,
            'name' => 'Margherita Pizza',
            'description' => 'Classic tomato and mozzarella',
            'ingredients' => 'Tomato sauce, mozzarella, basil',
            'price' => 12.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant1->id,
            'category_id' => $pizza->id,
            'name' => 'Pepperoni Pizza',
            'description' => 'Loaded with pepperoni',
            'ingredients' => 'Tomato sauce, mozzarella, pepperoni',
            'price' => 14.99,
            'is_available' => true,
            'sort_order' => 2,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant1->id,
            'category_id' => $drinks->id,
            'name' => 'Coca Cola',
            'description' => 'Cold refreshing soda',
            'ingredients' => 'Carbonated water, sugar',
            'price' => 2.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        $restaurant2 = Restaurant::create([
            'name' => 'Burger House',
            'email' => 'burger@example.com',
            'password' => 'password123',
            'phone' => '123-456-7891',
            'address' => '456 Oak Avenue',
            'city' => 'Los Angeles',
            'description' => 'Delicious burgers and fries',
            'status' => 'active',
        ]);

        $burgers = Category::create([
            'restaurant_id' => $restaurant2->id,
            'name' => 'Burgers',
            'description' => 'Juicy burgers',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $sides = Category::create([
            'restaurant_id' => $restaurant2->id,
            'name' => 'Sides',
            'description' => 'Fries and more',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant2->id,
            'category_id' => $burgers->id,
            'name' => 'Classic Burger',
            'description' => 'Beef patty with lettuce and tomato',
            'ingredients' => 'Beef, lettuce, tomato, cheese, bun',
            'price' => 9.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant2->id,
            'category_id' => $burgers->id,
            'name' => 'Bacon Burger',
            'description' => 'With crispy bacon',
            'ingredients' => 'Beef, bacon, cheese, lettuce, bun',
            'price' => 11.99,
            'is_available' => true,
            'sort_order' => 2,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant2->id,
            'category_id' => $sides->id,
            'name' => 'French Fries',
            'description' => 'Crispy golden fries',
            'ingredients' => 'Potatoes, salt',
            'price' => 3.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        $restaurant3 = Restaurant::create([
            'name' => 'Sushi Master',
            'email' => 'sushi@example.com',
            'password' => 'password123',
            'phone' => '123-456-7892',
            'address' => '789 Sushi Lane',
            'city' => 'San Francisco',
            'description' => 'Fresh sushi and sashimi',
            'status' => 'active',
        ]);

        $sushiRolls = Category::create([
            'restaurant_id' => $restaurant3->id,
            'name' => 'Sushi Rolls',
            'description' => 'Delicious rolls',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant3->id,
            'category_id' => $sushiRolls->id,
            'name' => 'California Roll',
            'description' => 'Crab, avocado, cucumber',
            'ingredients' => 'Crab, avocado, cucumber, rice',
            'price' => 8.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant3->id,
            'category_id' => $sushiRolls->id,
            'name' => 'Spicy Tuna Roll',
            'description' => 'Spicy tuna with sriracha',
            'ingredients' => 'Tuna, sriracha, cucumber, rice',
            'price' => 10.99,
            'is_available' => true,
            'sort_order' => 2,
        ]);

        $restaurant4 = Restaurant::create([
            'name' => 'Taco Fiesta',
            'email' => 'taco@example.com',
            'password' => 'password123',
            'phone' => '123-456-7893',
            'address' => '321 Taco Blvd',
            'city' => 'Austin',
            'description' => 'Authentic Mexican tacos',
            'status' => 'active',
        ]);

        $tacos = Category::create([
            'restaurant_id' => $restaurant4->id,
            'name' => 'Tacos',
            'description' => 'Spicy tacos',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant4->id,
            'category_id' => $tacos->id,
            'name' => 'Beef Tacos',
            'description' => 'Seasoned ground beef',
            'ingredients' => 'Beef, lettuce, cheese, tomato',
            'price' => 8.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant4->id,
            'category_id' => $tacos->id,
            'name' => 'Chicken Tacos',
            'description' => 'Grilled chicken tacos',
            'ingredients' => 'Chicken, lettuce, cheese, salsa',
            'price' => 8.99,
            'is_available' => true,
            'sort_order' => 2,
        ]);

        $restaurant5 = Restaurant::create([
            'name' => 'Dragon Wok',
            'email' => 'chinese@example.com',
            'password' => 'password123',
            'phone' => '123-456-7894',
            'address' => '654 Dragon St',
            'city' => 'Seattle',
            'description' => 'Traditional Chinese cuisine',
            'status' => 'active',
        ]);

        $chinese = Category::create([
            'restaurant_id' => $restaurant5->id,
            'name' => 'Chinese Dishes',
            'description' => 'Spicy and tasty',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant5->id,
            'category_id' => $chinese->id,
            'name' => 'Kung Pao Chicken',
            'description' => 'Spicy chicken with peanuts',
            'ingredients' => 'Chicken, peanuts, chili',
            'price' => 12.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant5->id,
            'category_id' => $chinese->id,
            'name' => 'Sweet and Sour Pork',
            'description' => 'Classic flavor',
            'ingredients' => 'Pork, pineapple, bell peppers',
            'price' => 11.99,
            'is_available' => true,
            'sort_order' => 2,
        ]);

        $restaurant6 = Restaurant::create([
            'name' => 'Pasta Paradise',
            'email' => 'italian@example.com',
            'password' => 'password123',
            'phone' => '123-456-7895',
            'address' => '987 Pasta Ave',
            'city' => 'Boston',
            'description' => 'Homemade pasta and Italian dishes',
            'status' => 'active',
        ]);

        $pasta = Category::create([
            'restaurant_id' => $restaurant6->id,
            'name' => 'Pasta',
            'description' => 'Delicious pasta dishes',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant6->id,
            'category_id' => $pasta->id,
            'name' => 'Spaghetti Bolognese',
            'description' => 'Classic meat sauce',
            'ingredients' => 'Spaghetti, beef, tomato sauce',
            'price' => 13.99,
            'is_available' => true,
            'sort_order' => 1,
        ]);

        Meal::create([
            'restaurant_id' => $restaurant6->id,
            'category_id' => $pasta->id,
            'name' => 'Fettuccine Alfredo',
            'description' => 'Creamy parmesan sauce',
            'ingredients' => 'Fettuccine, cream, parmesan',
            'price' => 12.99,
            'is_available' => true,
            'sort_order' => 2,
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'phone' => '555-1234',
            'address' => '789 Customer St',
            'city' => 'New York',
        ]);

        $this->command->info('Test data created successfully!');

    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\{
//     Restaurant, Category, Meal, User, Admin, Order, OrderItem
// };

// class DatabaseSeeder extends Seeder
// {
//     public function run(): void
//     {
//         // Create Admin
//         Admin::factory()->create([
//             'name'  => 'Admin',
//             'email' => 'admin@foodexpress.com',
//             'password' => 'admin123',
//         ]);

//         // Create Users
//         $users = User::factory(20)->create();

//         // Create Restaurants
//         Restaurant::factory(15)->create()->each(function ($restaurant) use ($users) {

//             // Create Categories
//             $categories = Category::factory(5)
//                 ->create(['restaurant_id' => $restaurant->id]);

//             // Create Meals
//             foreach ($categories as $category) {
//                 $meals = Meal::factory(10)
//                     ->create([
//                         'restaurant_id' => $restaurant->id,
//                         'category_id'   => $category->id,
//                     ]);

//                 // Create Orders with Items
//                 Order::factory(3)->create([
//                     'restaurant_id' => $restaurant->id,
//                     'user_id' => fake()->boolean(50) ? $users->random()->id : null,
//                 ])->each(function ($order) use ($meals) {
//                     OrderItem::factory(3)
//                         ->create([
//                             'order_id' => $order->id,
//                             'meal_id'  => $meals->random()->id,
//                         ]);
//                 });
//             }
//         });

//         $this->command->info('🔥 Data generated successfully.');
//     }
// }
