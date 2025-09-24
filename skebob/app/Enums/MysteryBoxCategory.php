<?php

namespace App\Enums;

enum MysteryBoxCategory: string
{
    /**
     * Uzskaitījums noslēpuma kastei (MysteryBox) laukam 'category'
     */
    case Basic = 'basic';
    case Deluxe = 'deluxe';
    case Premium = 'premium';

}
