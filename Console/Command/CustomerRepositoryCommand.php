<?php

declare(strict_types=1);

namespace Denal05\EavExerciseGetDobViaCli\Console\Command;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CustomerRepositoryCommand extends Command
{
    private const EMAIL = 'email';
    private $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
	    parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('customer:repository:query');
        $this->setDescription("This command will query the customer repository; it will return the date of birth of a customer based on a customer's email.");
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
             if ($email = $input->getOption(self::EMAIL)) {
                 $customerByEmail = $this->customerRepository->get($email);
                 $dobByEmail = $customerByEmail->getDob();
                 $output->writeln("<info>DoB = $dobByEmail </info>");
             }

             // $output->writeln('<info>Success message.</info>');
             // $output->writeln('<comment>Some comment.</comment>');

             // if (rand(0, 1)) {
             //    throw new LocalizedException(__('An error occurred.'));
             // }
         } catch (NoSuchEntityException $exception) {
             $exitCode = 1;
             throw new LocalizedException(
                 __($exception->getMessage())
             );
         }
         return $exitCode;
     }
}
