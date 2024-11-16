<?php

declare(strict_types=1);

namespace Denal05\EavExerciseGetDobViaCli\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Denal05\EavExerciseGetDobViaCli\Helper\RawSqlQuery;

class RawSqlCommand extends Command
{
    private const EMAIL = 'email';

    protected $rawSqlQuery = '';

    public function __construct(
	    RawSqlQuery $rawSqlQuery
    ) {
        $this->rawSqlQuery = $rawSqlQuery;
	    parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('sql:raw:query');
        $this->setDescription("This command will run a raw SQL query; it will return the date of birth of a customer based ona customer's address.");
        $this->addOption(
            self::EMAIL,
            null,
            InputOption::VALUE_REQUIRED,
            'Email'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
     protected function execute(InputInterface $input, OutputInterface $output): int
     {
         $exitCode = 0;

         try {
            $email = "";
             if ($email = $input->getOption(self::EMAIL)) {
                 $output->writeln('<info>Provided email is `' . $email . '`</info>');
                 $result = $this->rawSqlQuery->runSqlQueryGetDobByEmail($email);
                 $output->writeln('<info>Raw SQL Query Result: `' . print_r($result) . '`</info>');
             }

             // $output->writeln('<info>Success message.</info>');
             // $output->writeln('<comment>Some comment.</comment>');

             // if (rand(0, 1)) {
             //    throw new LocalizedException(__('An error occurred.'));
             // }
         } catch (LocalizedException $e) {
             $output->writeln(sprintf(
                 '<error>%s</error>',
                 $e->getMessage()
             ));
             $exitCode = 1;
         }

         return $exitCode;
     }
}
