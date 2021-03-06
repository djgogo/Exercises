<?php


class HamburgerRecipe extends Recipe
{
    /**
     * @return array
     */
    protected function getIngredients() : array
    {
        return [
            'LowerBread',
            'Sauce',
            'Salad',
            'Patty',
            'Tomato',
            'UpperBread'
        ];
    }

    public function getBurgerName() : string
    {
        return 'Hamburger';
    }
}