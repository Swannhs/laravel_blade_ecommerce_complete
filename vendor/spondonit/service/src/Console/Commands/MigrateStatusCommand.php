<?php

namespace SpondonIt\Service\Console\Commands;;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Support\Collection;

class MigrateStatusCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spondonit:migrate-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var mixed
     */
    protected $migrator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->migrator = app()->make('migrator');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->migrator->repositoryExists()) {
            return false;
        }

        $ran = $this->migrator->getRepository()->getRan();

        $batches = $this->migrator->getRepository()->getMigrationBatches();

        if (count($migrations = $this->getStatusFor($ran, $batches)) > 0) {
            return !in_array(false, $migrations->toArray() );
        } else {
            return false;
        }
    }

    /**
     * Get the status for the given ran migrations.
     *
     * @param array $ran
     * @param array $batches
     * @return Collection
     */
    protected function getStatusFor(array $ran, array $batches)
    {
        return Collection::make($this->getAllMigrationFiles())
            ->map(function ($migration) use ($ran, $batches) {
                $migrationName = $this->migrator->getMigrationName($migration);

                return in_array($migrationName, $ran);
            });
    }

    /**
     * Get an array of all of the migration files.
     *
     * @return array
     */
    protected function getAllMigrationFiles()
    {
        return $this->migrator->getMigrationFiles($this->getMigrationPaths());
    }
}
