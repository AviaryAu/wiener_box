<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            foreach ($this->recipes() as $position => $recipe) {
                Recipe::firstOrCreate(['slug' => $recipe['slug']], [
                    ...$recipe, 'position' => $position, 'published' => true,
                ]);
            }
        });
    }

    /**
     * @return list<array{slug: string, title: string, category: string, description: string, image: string, image_alt: string, prep_minutes: int, cook_minutes: int, servings: int, ingredients: list<string>, method: list<string>, tip: string, featured?: bool}>
     */
    private function recipes(): array
    {
        return [
            [
                'slug' => 'lemon-mustard-chicken-sausages',
                'title' => 'Lemon & mustard chicken sausage tray bake',
                'category' => 'Sausages',
                'description' => 'Golden chicken sausages, roast potatoes and a mustardy pan sauce. One tray. Very little washing up. Winner, winner. You know the rest.',
                'image' => '/images/food/lemon-mustard-chicken-sausages.webp',
                'image_alt' => 'Browned chicken sausages with roasted potatoes, lemon and mustard sauce in a cream enamel tray',
                'prep_minutes' => 15, 'cook_minutes' => 45, 'servings' => 4, 'featured' => true,
                'ingredients' => [
                    '8 fresh chicken sausages (about 700–800 g)',
                    '700 g baby potatoes, cut into 2–3 cm pieces',
                    '1 lemon, half juiced and half cut into wedges',
                    '4 garlic cloves, lightly crushed',
                    '2 tbsp olive oil', '1 tbsp Dijon mustard', '1 tbsp wholegrain mustard',
                    '100 ml chicken stock', '4 thyme sprigs', '½ tsp salt and black pepper, to taste',
                ],
                'method' => [
                    'Heat the oven to 220°C, or 200°C fan-forced. Toss the potatoes and garlic with 1 tbsp oil and half the salt in a large roasting tray. Roast for 15 minutes.',
                    'Mix the remaining oil with both mustards, lemon juice, stock, the remaining salt and a little pepper.',
                    'Nestle the chicken sausages among the potatoes. Add the lemon wedges and thyme, then spoon over the mustard mixture. Leave the sausages partly exposed so they can brown.',
                    'Roast for another 25–30 minutes, turning the sausages halfway through, until the potatoes are tender. Follow the sausage pack directions and check that the centre of the thickest chicken sausage reaches at least 75°C; larger sausages may need longer.',
                    'Spoon the mustardy pan juices over the chicken sausages and potatoes, then bring the tray to the table.',
                ],
                'tip' => 'Use a roomy tray so the sausages roast instead of steam. Keep the casings intact to hold onto their juices. A spoonful of sweet mustard sauce on the side is a very good idea.',
            ],
            [
                'slug' => 'bratwurst-and-sauerkraut',
                'title' => 'Bratwurst & warm sauerkraut',
                'category' => 'Sausages',
                'description' => 'Golden bratwurst, buttery kraut and a proper dollop of mustard. A German classic that keeps the fuss to a minimum.',
                'image' => '/images/food/bratwurst-reference.webp',
                'image_alt' => 'Pan-browned bratwurst with warm sauerkraut and mustard on a cream plate',
                'prep_minutes' => 5, 'cook_minutes' => 25, 'servings' => 4,
                'ingredients' => [
                    '8 pork bratwurst sausages', '500 g ready-fermented sauerkraut, drained',
                    '1 small onion, thinly sliced', '1 tbsp butter', '1 tbsp neutral oil',
                    '150 ml vegetable stock', '½ tsp caraway seeds', '4 tbsp German mustard, to serve',
                    '1 tbsp chopped parsley',
                ],
                'method' => [
                    'Melt the butter in a saucepan over medium heat. Add the onion and soften for 5 minutes.',
                    'Stir in the sauerkraut, stock and caraway. Cover and simmer gently for 15–20 minutes, stirring occasionally.',
                    'Meanwhile, heat the oil in a frying pan over medium-low heat. Cook the bratwurst for about 15–20 minutes, turning regularly. Follow the pack instructions and check that raw sausages reach at least 75°C in the centre.',
                    'Divide the sauerkraut among four plates, add the bratwurst and mustard, then finish with parsley.',
                ],
                'tip' => 'Add warm German potato salad for a bigger feed. Keep the heat gentle to brown the sausages without splitting their skins.',
            ],
            [
                'slug' => 'wieners-mustard-and-pickles',
                'title' => 'Wieners, mustard & pickles',
                'category' => 'Sausages',
                'description' => 'A little beer-bath for the wieners. A little mustard for the plate. The easiest way to turn a few good links into lunch.',
                'image' => '/images/food/classic-wieners-reference.webp',
                'image_alt' => 'Classic wieners served with mustard and cornichons on a cream plate',
                'prep_minutes' => 5, 'cook_minutes' => 15, 'servings' => 4,
                'ingredients' => [
                    '8 fully cooked pork wieners or frankfurters', '330 ml lager, or vegetable stock',
                    '500 ml water, plus extra if needed', '1 bay leaf', '4 tbsp German mustard',
                    '12 cornichons', '4 bread rolls, to serve',
                ],
                'method' => [
                    'Pour the lager or stock and water into a wide saucepan. Add the bay leaf and bring to a gentle simmer.',
                    'Lower the heat, add the fully cooked wieners and top up with water if needed to cover them. Warm gently for 8–10 minutes, or as directed on the pack, until piping hot throughout. Avoid a rolling boil.',
                    'Lift out the wieners and discard the cooking liquid and bay leaf.',
                    'Serve with mustard, cornichons and the bread rolls. Add a spoonful of curry ketchup if the mood takes you.',
                ],
                'tip' => 'This recipe uses fully cooked wieners. If yours are raw, follow their pack directions and cook to at least 75°C in the centre before serving.',
            ],
            [
                'slug' => 'warm-german-potato-salad',
                'title' => 'Warm German potato salad',
                'category' => 'Sides',
                'description' => 'Waxy potatoes, a tangy mustard dressing and a generous scattering of chives. Your sausage’s new favourite plus-one.',
                'image' => '/images/food/potato-salad.webp',
                'image_alt' => 'Sliced warm potatoes with onion, mustard dressing and chives in a cream serving bowl',
                'prep_minutes' => 10, 'cook_minutes' => 25, 'servings' => 4,
                'ingredients' => [
                    '800 g small waxy potatoes', '1 small onion, finely diced', '150 ml vegetable stock',
                    '2 tbsp apple cider vinegar', '1 tbsp Dijon mustard', '2 tbsp neutral oil',
                    '1 tsp sugar', '2 tbsp chopped chives', 'Salt and black pepper, to taste',
                ],
                'method' => [
                    'Put the whole potatoes in a saucepan, cover with cold salted water and bring to the boil. Simmer for 15–20 minutes, until a knife slips easily into the centre.',
                    'Meanwhile, bring the stock and onion to a simmer in a small pan. Cook gently for 5 minutes, then remove from the heat and whisk in the vinegar, mustard, oil and sugar.',
                    'Drain the potatoes. When cool enough to handle, slice into thick rounds and place in a serving bowl.',
                    'Pour the warm dressing over the potatoes and fold gently. Leave for 5 minutes so the potatoes absorb the dressing, then add the chives and season to taste. Serve warm.',
                ],
                'tip' => 'Waxy potatoes hold their shape best. Fold with a broad spoon so you get potato salad, not accidental mash.',
            ],
            [
                'slug' => 'apple-and-caraway-sauerkraut',
                'title' => 'Apple & caraway sauerkraut',
                'category' => 'Sides',
                'description' => 'Give a jar of kraut a little love with sweet apple, soft onion and caraway. Tangy, buttery and excellent next to a brat.',
                'image' => '/images/food/apple-sauerkraut.webp',
                'image_alt' => 'Warm sauerkraut with apple pieces and caraway seeds in a red bowl',
                'prep_minutes' => 10, 'cook_minutes' => 20, 'servings' => 4,
                'ingredients' => [
                    '500 g ready-fermented sauerkraut, drained', '1 apple, cored and cut into small pieces',
                    '1 small onion, thinly sliced', '1 tbsp butter', '100 ml apple juice',
                    '½ tsp caraway seeds', 'Black pepper, to taste',
                ],
                'method' => [
                    'Melt the butter in a saucepan over medium heat. Add the onion and cook for 5 minutes until softened.',
                    'Add the apple and caraway, then cook for 2 minutes, stirring.',
                    'Fold in the drained sauerkraut and pour in the apple juice. Cover and simmer gently for 10 minutes.',
                    'Remove the lid and cook for 3 more minutes to reduce any excess liquid. Add black pepper to taste and serve warm.',
                ],
                'tip' => 'Start with a jar of fermented sauerkraut. This is a quick cooked side, so there is no home-fermentation project required.',
            ],
            [
                'slug' => 'quick-curry-ketchup',
                'title' => 'Quick curry ketchup',
                'category' => 'Sauces',
                'description' => 'A Berlin-inspired little number for sausages, chips and enthusiastic dipping. A saucepan, a few pantry staples, and you’re away.',
                'image' => '/images/food/curry-ketchup.webp',
                'image_alt' => 'Rich red curry ketchup in a cream bowl with a dusting of curry powder',
                'prep_minutes' => 5, 'cook_minutes' => 10, 'servings' => 6,
                'ingredients' => [
                    '150 g tomato ketchup', '1 tbsp mild curry powder', '½ tsp smoked paprika',
                    '1 tbsp apple cider vinegar', '1 tsp brown sugar', '3 tbsp water',
                ],
                'method' => [
                    'Add the ketchup, curry powder, paprika, vinegar, sugar and water to a small saucepan. Stir until smooth.',
                    'Bring to a very gentle simmer over low heat, then cook for 8–10 minutes, stirring often so it does not catch.',
                    'Taste and adjust with a little extra vinegar for tang or a splash of water for a looser sauce.',
                    'Serve warm over sliced cooked sausages, or cool slightly for dipping. Finish with a pinch more curry powder if you like.',
                ],
                'tip' => 'Makes roughly 200 ml. Turn cooked bratwurst into an easy currywurst-inspired plate with this sauce and a side of chips.',
            ],
            [
                'slug' => 'sweet-mustard-sauce',
                'title' => 'Sweet mustard sauce',
                'category' => 'Sauces',
                'description' => 'A quick Bavarian-inspired mustard sauce that brings sweet, sharp and a little bite. Extremely friendly with a sausage.',
                'image' => '/images/food/sweet-mustard.webp',
                'image_alt' => 'Coarse sweet mustard sauce with whole mustard seeds in a yellow bowl',
                'prep_minutes' => 5, 'cook_minutes' => 0, 'servings' => 6,
                'ingredients' => [
                    '4 tbsp wholegrain mustard', '2 tbsp Dijon mustard', '2 tbsp honey',
                    '1 tbsp apple cider vinegar', '1 tbsp water, as needed', 'A pinch of black pepper',
                ],
                'method' => [
                    'Combine the wholegrain mustard, Dijon and honey in a small bowl.',
                    'Stir in the apple cider vinegar and pepper. Add the water a little at a time until the sauce is easy to spoon.',
                    'Taste and add a little more honey for sweetness or vinegar for sharpness. Serve alongside warm sausages, roast chicken or a soft pretzel.',
                ],
                'tip' => 'Makes roughly 150 ml. This is a quick sauce using prepared mustard, so you can skip soaking or grinding mustard seeds.',
            ],
        ];
    }
}
