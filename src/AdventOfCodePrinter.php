<?php
declare(strict_types=1);


namespace AdventOfCode;

use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestResult;
use PHPUnit\TextUI\ResultPrinter;
use PHPUnit\Util\TestDox\NamePrettifier;

class AdventOfCodePrinter extends ResultPrinter
{
    private $actualResults = [];

    public function printResult(TestResult $result)
    {
        parent::printResult($result);

        if ($result->failureCount() > 0) {
            $this->writeNewLine();
            $this->writeWithColor('fg-white, bg-red', 'Actual results are not displayed as there are failing tests!');
        } else {
            $namePrettifier = new NamePrettifier();

            $this->writeNewLine();
            $this->writeWithColor('fg-black, bg-cyan', 'Actual results');
            foreach ($this->actualResults as $result) {
                $this->write(
                    "- " .
                    $namePrettifier->prettifyTestMethod($result['method']) .
                    ": " .
                    $result['output'] .
                    PHP_EOL
                );
            }
        }
    }

    public function startTest(Test $test)
    {
        parent::startTest($test);

        $test->setOutputCallback(function ($output) use ($test) {
            if (!empty($output)) {
                $this->actualResults[] = [
                    "method" => $test->getName(),
                    "output" => $output,
                ];
            }
        });
    }
}
