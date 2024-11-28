<?php

namespace App\Config;

enum Statut: string
{
    case valide = 'Validée';
    case preparation = 'En préparation';
    case expedie = 'Expediée';
    case livre = 'Livrée';
    case magasin = 'Disponible en magasin';
}