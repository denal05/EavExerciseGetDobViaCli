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
    private const TABLENAME = 'tablename';
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
        $this->setDescription('This command will run a raw SQL query given the parameters.');
        $this->addOption(
            self::TABLENAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Table Name'
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
             if ($name = $input->getOption(self::TABLENAME)) {
                 $output->writeln('<info>Provided table name is `' . $name . '`</info>');
                 $result = $this->rawSqlQuery->runSqlQueryOnTable($name);
                 $output->writeln('<info>SQL Query Result: `' . print_r($result) . '`</info>');
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
