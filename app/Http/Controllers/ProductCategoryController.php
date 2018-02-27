<?php

namespace App\Http\Controllers;

use App\Repositories\ProductCategoryRepo;

class ProductCategoryController extends Controller
{
    /**
     * @var $productCategory
     */
    private $productCategory;

    /**
     * ProductCategoryController constructor.
     *
     * @param App\Repositories\ProductCategoryRepo $productCategory
     */
    public function __construct(ProductCategoryRepo $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    /**
     * Get all product categories.
     *
     * @return Illuminate\View
     */
    public function getAllProductCategories($id = null)
    {
        $productCategories = $this->productCategory->getAll();

        return $productCategories;
    }

    private function getBody(Request $request, $parameters, $parameterType, $parameterTypeIndex)
    {
        if($request->has($parameterType))
        {
            if(count($request->input($parameterType)) > 0)
            {
                foreach($request->input($parameterType) as $parameter)
                {
                    $obj = new \stdClass();
                    $obj->name = $this->parameterType[$parameterTypeIndex];
                    $obj->in = $this->parameterType[$parameterTypeIndex];
                    $obj->description = $this->parameterDescription;
                    $obj->required = $this->required;
                    $obj->schema = $this->getBodyContent($request);

                    array_push($parameters, $obj);
                }
            }
        }

        return $parameters;
    }

    private function getBodyContent(Request $request)
    {
        $schema = new \stdClass();
        $schema->type = 'object';

        $properties = new \stdClass();
        $items = $request->input('request_body')[0];
        foreach ($items as $key => $item)
        {
            $properties->{$key} = new \stdClass();

            $properties->{$key}->type = $this->myGettype(json_decode(json_encode($item)));
            $properties->{$key}->description = 'Parameter Description';
            if($this->getItemFormat($item))
            {
                $properties->{$key}->format = $this->getItemFormat($item);
            }
            Log::info('Body content item data type '.$this->myGettype(json_decode(json_encode($item))));
            Log::info('Body content Item '.print_r($item,true));
            switch ($this->myGettype(json_decode(json_encode($item)))) {
                case "array":
                    $properties->{$key}->items = $this->getRequestParameterArrayBody($item);
                    break;
                case "object":
                    $properties->{$key}->properties = $this->getResponseParameterObjectBody($item);
                    break;
                default:
                    $properties->{$key}->example = $item;
            }
        }

        $schema->properties = $properties;

        return $schema;
    }

    private function getRequestParameterArrayBody($items)
    {
        $properties = new \stdClass();

        foreach ($items as $key => $item)
        {
            Log::info('getRequestParameterArrayBody data type '.$this->myGettype(json_decode(json_encode($item))));
            switch ($this->myGettype(json_decode(json_encode($item)))) {
                case "object":
                    $properties = $this->getRequestParameterObjectBody($item);
                    break;
                default:
                    $properties->type = $item;
            }
        }

        return $properties;
    }

    private function getRequestParameterObjectBody($items)
    {
        $schema = new \stdClass();
        $schema->type = 'object';
        Log::info('getRequestParameterObjectBody '.print_r($items,true));
        $properties = new \stdClass();
        foreach ($items as $key => $item)
        {
            Log::info('getRequestParameterObjectBody data type '.$this->myGettype(json_decode(json_encode($item))));
            if(!is_null($item) && count($item) > 0)
            {
                $properties->{$key} = new \stdClass();

                $properties->{$key}->type = $this->myGettype(json_decode(json_encode($item)));
                $properties->{$key}->description = 'Request parameter Description';
                if($this->getItemFormat($item))
                {
                    $properties->{$key}->format = $this->getItemFormat($item);
                }
                switch ($this->myGettype(json_decode(json_encode($item)))) {
                    case "array":
                        $properties->{$key}->items = $this->getRequestParameterArrayBody($item);
                        break;
                    case "object":
                        $properties->{$key}->properties = $this->getRequestParameterObjectBody($item);
                        break;
                    default:
                        $properties->{$key}->example = $item;
                }
            }
        }

        $schema->properties = $properties;

        return $schema;
    }

    private function getMethodResponses(Request $request)
    {
        $response_body = new \stdClass();

        if($request->has('responses'))
        {
            if(count($request->input('responses')) > 0)
            {
                foreach($request->input('responses') as $key => $response)
                {
                    $response_body->{$key} = new \stdClass();
                    $response_body->{$key}->description = 'Response message';
                    $response_body->{$key}->schema = $this->getResponseBody($response);
                }
            }
        }

        return $response_body;
    }

    private function getResponseBody($response)
    {
        $schema = new \stdClass();
        $schema->type = 'object';

        $properties = new \stdClass();
        foreach ($response as $key => $item)
        {
            if(!is_null($item) && count($item) > 0)
            {
                $properties->{$key} = new \stdClass();

                $properties->{$key}->type = $this->myGettype(json_decode(json_encode($item)));
                $properties->{$key}->description = 'Response parameter Description';
                if($this->getItemFormat($item))
                {
                    $properties->{$key}->format = $this->getItemFormat($item);
                }
                switch ($this->myGettype(json_decode(json_encode($item)))) {
                    case "array":
                        $properties->{$key}->items = $this->getResponseParameterArrayBody($item);
                        break;
                    case "object":
                        $properties->{$key}->properties = $this->getResponseParameterObjectBody($item);
                        break;
                    default:
                        $properties->{$key}->example = $item;
                }
            }
        }

        $schema->properties = $properties;

        return $schema;
    }

    private function getResponseParameterObjectBody($items)
    {
        $properties = new \stdClass();
        foreach ($items as $key => $item)
        {
            $properties->{$key} = new \stdClass();

            $properties->{$key}->type = $this->myGetType(json_decode(json_encode($item)));
            $properties->{$key}->description = 'Response parameter Description';
            if($this->getItemFormat($item))
            {
                $properties->{$key}->format = $this->getItemFormat($item);
            }

            switch ($this->myGettype(json_decode(json_encode($item)))) {
                case "array":
                    $properties->{$key}->items = $this->getResponseParameterArrayBody($item);
                    break;
                case "object":
                    $properties->{$key}->properties = $this->getResponseParameterObjectBody($item);
                    break;
                default:
                    $properties->{$key}->example = $item;
            }
        }

        return $properties;
    }

    private function getResponseParameterArrayBody($items)
    {
        $properties = new \stdClass();

        foreach ($items as $key => $item)
        {
            Log::info('getResponseParameterArrayBody'.$this->myGettype(json_decode(json_encode($item))).'/'.$key);
            switch ($this->myGettype(json_decode(json_encode($item)))) {
                case "object":
                    $properties = $this->getResponseParameterObjectBody($item);
                    break;
                default:
                    $properties->type = $item;
            }
        }

        return $properties;
    }
}
