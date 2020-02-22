<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['USER_EDIT', 'USER_VIEW'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'USER_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                if($this->security->isGranted('ROLE_CAISSIER') && $user === $subject){
                    return true;
                }elseif (($this->security->isGranted('ROLE_ADMIN') && $subject->getRole()->getLibelle() === 'ROLE_CAISSIER') || $user === $subject) {
                    return true;
                }elseif ($this->security->isGranted('ROLE_ADMIN_SYST')) {
                    return true;
                }
                break;
            case 'USER_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                if($this->security->isGranted('ROLE_CAISSIER') && $user === $subject){
                    return true;
                }elseif ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
        }

        return false;
    }
}
