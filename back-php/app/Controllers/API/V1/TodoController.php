<?php

namespace App\Controllers\API\V1;

use CodeIgniter\API\ResponseTrait;
use App\Repositories\BaseRepository;
use CodeIgniter\HTTP\ResponseInterface;
use App\DTO\Response\Todo\TodoResponseDTO;
use App\DTO\Request\Todo\TodoCreateRequestDTO;
use App\DTO\Request\Todo\TodoUpdateRequestDTO;
use App\DTO\Response\Todo\TodoWithOutIdResponseDTO;

/**
 * This class represents the TodoController which is responsible for handling the API requests related to the Todo resource.
 * It extends the ApiController class and uses the ResponseTrait trait.
 * 
 * @author Guillaume Cornez
 */
class TodoController extends ApiController
{
    use ResponseTrait;
    
    private $todoRepository;

    /**
     * Constructor method for the TodoController class.
     * It initializes the parent constructor and sets the todoRepository property to the instance of the 'todo' repository service.
     */
    public function __construct()
    {
        parent::__construct();
        $this->todoRepository = service('repository', 'Todo');
    }

    /**
     *     @OA\Get(
     *     path="/api/v1/todo",
     *     tags={"Todo"},
     *     summary="List todos",
     *     description="Get a list of todo entities at TodoWithOutIdResponseDTO format",
     *     operationId="listTodo",
     *     @OA\Response(
     *         response=200,
     *         description="Get a list of todo entities at TodoWithOutIdResponseDTO format",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=200),
     *                                        @OA\Property(property="success", type="bool", example="true"), 
     *                                        @OA\Property(property="data",type="array",@OA\Items(type="object",ref="#/components/schemas/TodoWithOutIdResponseDTO")),
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string")))
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=204),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string"))),
     *     ),
     * )
     * This method handles the GET request to retrieve all the Todo resources.
     * It returns a success response with the retrieved data or a success response with no content if there is no data.
     * 
     * @return HttpResponse
     */
    public function index()
    {
        $data = $this->todoRepository->getAll(BaseRepository::RESULT_AS_CUSTOM, TodoWithOutIdResponseDTO::class);
        if(count($data) == 0)
            return $this->success($data, ResponseInterface::HTTP_NO_CONTENT);
        
        return $this->success($data);
    }

    /**
    *     @OA\Get(
     *     path="/api/v1/todo/{id}",
     *     tags={"Todo"},
     *     summary="show a todo",
     *     description="Get a todo entity at TodoResponseDTO format",
     *     operationId="showTodo",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the todo.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get a todo entity at TodoResponseDTO format",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=200),
     *                                        @OA\Property(property="success", type="bool", example="true"), 
     *                                        @OA\Property(property="data",type="object",ref="#/components/schemas/TodoResponseDTO")),
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string")))
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=204),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string"))),
     *     ),
     * )
     * This method handles the GET request to retrieve a specific Todo resource by its id.
     * It returns a success response with the retrieved data or an error response with a not found status code if the resource is not found.
     * 
     * @param int $id The id of the Todo resource to retrieve.
     * 
     * @return HttpResponse
     */
    public function show($id)
    {
        $data = $this->todoRepository->getById($id, BaseRepository::RESULT_AS_CUSTOM, TodoResponseDTO::class);
        if($data == null)
            return $this->error(ResponseInterface::HTTP_NOT_FOUND, "Todo $id not found");

        return $this->success($data);
    }

    /**
     *     @OA\Post(
     *     path="/api/v1/todo",
     *     tags={"Todo"},
     *     summary="Create a todo",
     *     description="Create a todo entity with a TodoCreateRequestDTO object",
     *     operationId="createTodo",
     *     @OA\RequestBody(
     *         description="Creation of a todo",
     *         @OA\JsonContent(ref="#/components/schemas/TodoCreateRequestDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *          @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=200),
     *                                         @OA\Property(property="success", type="bool", example="true"), 
     *                                         @OA\Property(property="data",type="object", ref="#/components/schemas/TodoWithOutIdResponseDTO"),
     *                                         @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string")))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=400),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Name is required"))),
     *     ),
     *    @OA\Response(
     *         response=500,
     *         description="Creation failed",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=500),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string"))),
     *     ),
     * )
     * This method handles the POST request to create a new Todo resource.
     * It returns a success response with the created data and a created status code or an error response with an internal server error status code if the resource is not created.
     * 
     * @return HttpResponse
     */
    public function create()
    {
        $body = $this->getRequestInput($this->request);
        $todo = new TodoCreateRequestDTO($body);

        $errors = $todo->validate();
        if(count($errors) > 0)
            return $this->error(ResponseInterface::HTTP_BAD_REQUEST, $errors);
         
        $result = $this->todoRepository->insert($todo, BaseRepository::RESULT_AS_CUSTOM, TodoWithOutIdResponseDTO::class);
        if(!$result)
            return $this->error(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, "Todo not created");

        //TODO : return the created todo with the id
        return $this->success($todo, ResponseInterface::HTTP_CREATED);
    }

    /**
     *     @OA\Put(
     *     path="/api/v1/todo",
     *     tags={"Todo"},
     *     summary="Update a todo",
     *     description="Update a todo entity with a TodoUpdateRequestDTO object",
     *     operationId="updateTodo",
     *     @OA\RequestBody(
     *         description="Update a todo",
     *         @OA\JsonContent(ref="#/components/schemas/TodoUpdateRequestDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Update success",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=200),
     *                                        @OA\Property(property="success", type="bool", example="true"), 
     *                                        @OA\Property(property="data",type="object", ref="#/components/schemas/TodoResponseDTO"),
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string"))),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=400),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Name is required"))),
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Todo not found",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=404),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Todo 1 not found"))),
     *     ),
     *    @OA\Response(
     *         response=500,
     *         description="Updating failed",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=500),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Todo 1 not updated"))),
     *     ),
     * )
     * This method handles the PUT request to update an existing Todo resource.
     * It returns a success response with no content or an error response with a not found status code if the resource is not found or an internal server error status code if the resource is not updated.
     * 
     * @return HttpResponse
     */
    public function update()
    {
        $body = $this->getRequestInput($this->request);
        $todo = new TodoUpdateRequestDTO($body);

        if($this->todoRepository->getById($todo->id) == null)
            return $this->error(ResponseInterface::HTTP_NOT_FOUND, "Todo $todo->id not found");
         
        $result = $this->todoRepository->update($todo->id, $todo, BaseRepository::RESULT_AS_CUSTOM, Todo::class);
        if(!$result)
            return $this->error(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, "Todo $todo->id not updated");

        return $this->success([], ResponseInterface::HTTP_NO_CONTENT);

    }

    /**
     *     @OA\Delete(
     *     path="/api/v1/todo/{id}",
     *     tags={"Todo"},
     *     summary="Delete a todo",
     *     description="Delete a todo entity with a TodoDeleteRequestDTO object",
     *     operationId="deleteTodo",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the todo.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delete success",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=200),
     *                                        @OA\Property(property="success", type="bool", example="true"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="string"))),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=404),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Todo 1 not found"))),
     *     ),
     *    @OA\Response(
     *         response=500,
     *         description="Updating failed",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=500),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Todo 1 not deleted"))),
     *     ),
     * )
     * This method handles the DELETE request to delete an existing Todo resource.
     * It returns a success response with no content or an error response with a not found status code if the resource is not found or an internal server error status code if the resource is not deleted.
     * 
     * @param int $id The id of the Todo resource to delete.
     * 
     * @return HttpResponse
     */
    public function delete($id)
    {
        $data = $this->todoRepository->getById($id);
        if($data == null)
            return $this->error(ResponseInterface::HTTP_NOT_FOUND, "Todo $id not found");
        
        $result = $this->todoRepository->delete($id);
        if(!$result)
            return $this->error(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, "Todo $id not deleted");

        return $this->success([], ResponseInterface::HTTP_NO_CONTENT);
    }
}
