<?php
namespace App\Security;

use App\Entity\Run;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RunVoter extends Voter
{
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::DELETE))) {
            return false;
        }

        if (!$subject instanceof Run) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $run = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($run, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Run $run, User $user)
    {
        return $user === $run->getUser();
    }
}
