<?php
namespace App\DataFixtures\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[UniqueEntity(
    fields: ['email'],
    message: 'Impossible de créer un compte avec cet email.',
)]
class UtilisateurDto
{
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "L'email ne doit pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Email(
        message: "L'email '{{ value }}' est invalide."
    )]
    public ?string $email = null;

    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 12,
        max: 255,
        minMessage: "Le mot de passe doit contenir au minimum {{ limit }} caractères.",
        maxMessage: "Le mot de passe ne doit pas dépasser {{ limit }} caractères."
    )]
    #[Assert\NotCompromisedPassword(message: "Ce mot de passe est facilement piratable. Veuillez en choisir un autre.")]
    public ?string $password = null;

    #[Assert\EqualTo(
        propertyPath: "password",
        message: "Le mot de passe de confirmation doit être identique au mot de passe."
    )]
    public ?string $confirmPassword = null;

//     #[Assert\IsTrue(message: "Veuillez lire et accepter les conditions générales d'utilisation.")]
//     public ?bool $agreeTerms = null;


 }