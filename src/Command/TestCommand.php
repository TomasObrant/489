<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\LdapService;
use LdapRecord\Auth\BindException;
use LdapRecord\Connection;
use LdapRecord\Container;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Ldap\Ldap;

#[AsCommand(
    name: 'test',
    description: 'команда для тестов методов|сервисов|репозиториев',
)]
class TestCommand extends Command
{
    public function __construct(

    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->testConnect();     // вызови здесь свой метод, вместо этого
        return Command::SUCCESS;
    }

    protected function testConnect(): void
    {
        $connection = new Connection([
            // Mandatory Configuration Options
            'hosts'            => ['127.0.0.1'],
            'base_dn'          => 'dc=local,dc=com',
//            'username'         => 'cn=admin,dc=local,dc=com',
            'username'         => 'uid=admin,ou=system',
            'password'         => 'secret',

            // Optional Configuration Options
            'port'             => 10389, // Порт
            'use_ssl'          => false, // Использование SSL
            'use_tls'          => false, // Использование TLS
            'use_sasl'         => false, // Использование SASL
            'version'          => 3, // Версия LDAP
            'timeout'          => 5, // Таймаут
            'follow_referrals' => false, // Следование рефералам

            // Custom LDAP Options
            'options' => [
                // See: http://php.net/ldap_set_option
//                LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD
            ],

            // See: https://www.php.net/manual/en/function.ldap-sasl-bind.php
            'sasl_options' => [
                'mech' => null,
                'realm' => null,
                'authc_id' => null,
                'authz_id' => null,
                'props' => null,
            ],
        ]);



        try {
            $connection->connect();
            Container::addConnection($connection);
            echo "Все ок!";
        } catch (BindException $e) {
            $error = $e->getDetailedError();
            echo $error->getErrorCode() . "\n";
            echo $error->getErrorMessage() . "\n";
            echo $error->getDiagnosticMessage();
        }

//        $userDn = 'cn=user,dc=example,dc=com';
//        $userDn = 'uid=admin,ou=system';
//        $password = 'secret';
//
//        if ($connection->auth()->attempt($userDn, $password)) {
//            echo "Username and password are correct!";
//        } else {
//            echo "Authentication failed!";
//        }


    }


    protected function testConnect2(): void
    {
//        $ldap = Ldap::create('ext_ldap', ['connection_string' => 'ldap://127.0.0.1:10389', 'bind_username' => 'uid=admin,ou=system', 'bind_password' => 'secret']);
        $ldap = Ldap::create('ext_ldap', ['connection_string' => 'ldap://127.0.0.1:10389']);
        $ldap->bind();

        $activeDirectoryService = new LdapService($ldap);
        $activeDirectoryService->searchUsers('john.doe');
    }
}