<?php

namespace App\Service;

use Symfony\Component\Ldap\Ldap;

class LdapService
{
    private $ldap;

    public function __construct(Ldap $ldap)
    {
        $this->ldap = $ldap;
    }

    public function searchUsers($searchString)
    {
        $query = $this->ldap->query('ou=Users,dc=mydomain,dc=com', '(&(objectClass=user)(cn=' . $searchString . '))');
        $result = $query->execute();

        foreach ($result as $entry) {
            echo 'Username: ' . $entry->getAttribute('cn')[0] . '<br>';
            echo 'Email: ' . $entry->getAttribute('mail')[0] . '<br>';
            echo '----------------<br>';
        }
    }
}