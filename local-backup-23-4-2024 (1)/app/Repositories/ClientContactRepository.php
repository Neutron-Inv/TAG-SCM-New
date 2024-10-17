<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
class ClientContactRepository implements ClientContactRepositoryInterface
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
    public function update(array $data, $contact_id)
    {
        $update = $this->model->findOrFail($contact_id);
        return $update->update($data);
    }
    // remove record from the database
    public function delete($contact_id)
    {
        return $this->model->destroy($contact_id);
    }
    // show the record with the givenbalance_id
    public function show($contact_id)
    {
        return $this->model->findOrFail($contact_id);
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
interface ClientContactRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, $contact_id);
    public function delete($contact_id);
    public function show($contact_id);
}
