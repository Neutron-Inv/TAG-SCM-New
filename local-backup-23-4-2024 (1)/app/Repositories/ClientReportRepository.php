<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
class ClientReportRepository implements ClientReportRepositoryInterface
{
    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }
    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    // update record in the database
    public function update(array $data, $report_id)
    {
        $update = $this->model->findOrFail($report_id);
        return $update->update($data);
    }
    // remove record from the database
    public function delete($report_id)
    {
        return $this->model->destroy($report_id);
    }
    // show the record with the givenbalance_id
    public function show($report_id)
    {
        return $this->model->findOrFail($report_id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }
    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
interface ClientReportRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, $report_id);
    public function delete($report_id);
    public function show($report_id);
}
