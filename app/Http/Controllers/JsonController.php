<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class JsonController extends Controller
{
    protected $swagger = "2.0";
    protected $description = "API Document description";
    protected $version = "1.0.0";
    protected $title = "API Documentation";
    protected $apiUrl = "api.xyz.com";
    protected $basePath = "/api";
    protected $schemes = ['http', 'https'];
    protected $consumes = ['text/plain; charset=utf-8', 'application/json', 'multipart/form-data'];
    protected $produces = ['application/json'];
    protected $path = 'api-name';
    protected $method = 'get';
    protected $tags = ['Workflow Name'];
    protected $summary = 'Method Summary';
    protected $methodDescription = 'Method Description';
    protected $operationId = "operationId";
    protected $parameterType = ['query', 'path', 'header', 'formData', 'body'];
    protected $parameterDescription = 'Parameter Description';
    protected $required = true;
    protected $dataType = 'string';
    protected $format = 'format';

    public function convertToSwaggerJSON(Request $request)
    {
        $response = new \stdClass();

        $response->swagger = $this->swagger($request);
        $response->info = $this->info($request);
        $response->host = $this->host($request);
        $response->basePath = $this->basePath($request);
        $response->schemes = $this->schemes($request);
        $response->consumes = $this->consumes($request);
        $response->produces = $this->produces($request);
        $response->paths = $this->path($request);

        return Response::json($response);
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function swagger(Request $request)
    {
        return ($request->has('swagger')) ? $request->input('swagger') : $this->swagger;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function info(Request $request)
    {
        $info = new \stdClass();
        $info->description    = ($request->has('info.description')) ? $request->input('info.description') : $this->description;
        $info->version  = ($request->has('info.version')) ? $request->input('info.version') : $this->version;
        $info->title  = ($request->has('info.title')) ? $request->input('info.title') : $this->title;

        if($request->has('info.termsOfService'))
        {
            if($request->input('info.termsOfService'))
            {
                $info->termsOfservice = $request->input('info.termsOfService');
            }
        }

        if($request->has('info.contact'))
        {
            if($request->input('info.contact'))
            {
                $info->contact = $request->input('info.contact');
            }
        }

        if($request->has('info.license'))
        {
            if($request->input('info.license'))
            {
                $info->license = new \stdClass();
                if($request->has('info.licenses.name'))
                {
                    if($request->input('info.licenses.name'))
                    {
                        $info->license->name = $request->input('info.licenses.name');
                    }
                }

                if($request->has('info.licenses.url'))
                {
                    if($request->input('info.licenses.url'))
                    {
                        $info->license->url = $request->input('info.licenses.url');
                    }
                }

                if(count((array)$info->license) == 0)
                {
                    unset($info->license);
                }
            }
        }

        return $info;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function host(Request $request)
    {
        return ($request->has('host')) ? $request->input('host') : $this->apiUrl;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function basePath(Request $request)
    {
        return ($request->has('basePath')) ? $request->input('basePath') : $this->basePath;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function schemes(Request $request)
    {
        return ($request->has('schemes')) ? (count($request->input('schemes')) > 0) ? $request->input('schemes') : $this->schemes : $this->schemes;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function consumes(Request $request)
    {
        return ($request->has('consumes')) ? (count($request->input('consumes')) > 0) ? $request->input('consumes') : [$this->consumes[0]] : [$this->consumes[0]];
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function produces(Request $request)
    {
        return ($request->has('produces')) ? (count($request->input('produces')) > 0) ? $request->input('produces') : $this->produces : $this->produces;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function pathName(Request $request)
    {
        return ($request->has('path')) ? $request->input('path') : $this->path;
    }

    /**
     * @param Request $request
     * @return \stdClass
     */
    private function path(Request $request)
    {
        $path = new \stdClass();
        $path->{$this->pathName($request)} = $this->getMethod($request);
        return $path;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function getMethodName(Request $request)
    {
        return ($request->has('method')) ? $request->input('method') : $this->method;
    }

    /**
     * @param Request $request
     * @return \stdClass
     */
    private function getMethod(Request $request)
    {

        $method = new \stdClass();
        $method->{$this->getMethodName($request)} = $this->getMethodContent($request);

        return $method;
    }

    private function getMethodContent(Request $request)
    {
        $methodContent = new \stdClass();
        $methodContent->tags = $this->getMethodTags($request);
        $methodContent->summary = $this->getMethodSummary($request);
        $methodContent->description = $this->getMethodDescription($request);
        $methodContent->operationId = $this->getMethodOperationId($request);
        $methodContent->parameters = $this->getMethodParameters($request);
        $methodContent->responses = $this->getMethodResponses($request);

        return $methodContent;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function getMethodTags(Request $request)
    {
        return ($request->has('tags')) ? (count($request->input('tags')) > 0) ? $request->input('tags') : $this->tags : $this->tags;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function getMethodSummary(Request $request)
    {
        return ($request->has('summary')) ? $request->input('summary') : $this->summary;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function getMethodDescription(Request $request)
    {
        return ($request->has('description')) ? $request->input('description') : $this->methodDescription;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    private function getMethodOperationId(Request $request)
    {
        return ($request->has('operationId')) ? $request->input('operationId') : $this->operationId;
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    private function getMethodParameters(Request $request)
    {
        $parameters = array();
        $parameters = $this->getMethodParametersObject($request, $parameters, 'query_parameters', 0);
        $parameters = $this->getMethodParametersObject($request, $parameters, 'path_parameters', 1);
        $parameters = $this->getMethodParametersObject($request, $parameters, 'header_parameters', 2);
        $parameters = $this->getMethodParametersObject($request, $parameters, 'form_parameters', 3);
        $parameters = $this->getRequestBody($request, $parameters, 'request_body', 4);
        return $parameters;
    }

    /**
     * @param Request $request
     * @param $parameters
     * @return mixed
     */
    private function getMethodParametersObject(Request $request, $parameters, $parameterType, $parameterTypeIndex)
    {
        if($request->has($parameterType))
        {
            if(count($request->input($parameterType)) > 0)
            {
                foreach($request->input($parameterType) as $parameter)
                {
                    $obj = new \stdClass();
                    $obj->name = $parameter;
                    $obj->in = $this->parameterType[$parameterTypeIndex];
                    $obj->description = $this->parameterDescription;
                    $obj->required = $this->required;
                    $obj->type = $this->dataType;
                    if($parameterTypeIndex != 2 || $parameterTypeIndex != 3) {
                        $obj->format = $this->format;
                    }

                    array_push($parameters, $obj);
                }
            }
        }

        return $parameters;
    }

    /**
     * @param $item
     * @return bool|string
     */
    private function getItemFormat($item)
    {
        if(gettype($item) == 'integer')
        {
            return 'int64';
        }elseif (gettype($item) == 'string' && $this->isDate($item))
        {
            return 'date-time';
        }else{
            return false;
        }
    }

    /**
     * @param $value
     * @return bool
     */
    private function isDate($value)
    {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $var
     * @return string
     */
    private function myGetDataType($var)
    {
        if (is_array($var)) return "array";
        if (is_bool($var)) return "boolean";
        if (is_float($var)) return "float";
        if (is_int($var)) return "integer";
        if (is_null($var)) return "NULL";
        if (is_numeric($var)) return "numeric";
        if (is_object($var)) return "object";
        if (is_resource($var)) return "resource";
        if (is_string($var)) return "string";
        return "unknown type";
    }

    /**
     * @param Request $request
     * @param $parameters
     * @param $parameterType
     * @param $parameterTypeIndex
     * @return mixed
     */
    private function getRequestBody(Request $request, $parameters, $parameterType, $parameterTypeIndex)
    {
        if($request->has($parameterType))
        {
            if(count($request->input($parameterType)) > 0)
            {
                $obj = new \stdClass();
                $obj->name = $this->parameterType[$parameterTypeIndex];
                $obj->in = $this->parameterType[$parameterTypeIndex];
                $obj->description = 'Request body description';
                $obj->required = $this->required;
                $obj->schema = $this->getBodyContent($request->input('request_body')[0]);

                array_push($parameters, $obj);
            }
        }

        return $parameters;
    }

    /**
     * @param Request $request
     * @return \stdClass
     */
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
                    $response_body->{$key}->description = 'Response description';
                    $response_body->{$key}->schema = $this->getBodyContent($response);
                }
            }
        }

        return $response_body;
    }

    private function getBodyContent($items)
    {
        $schema = new \stdClass();
        $schema->type = 'object';

        $properties = new \stdClass();
        foreach ($items as $key => $item)
        {
            if(!is_null($item) && isset($item))
            {
                $properties->{$key} = new \stdClass();

                $properties->{$key}->type = $this->myGetDataType(json_decode(json_encode($item)));
                $properties->{$key}->description = 'Parameter Description';

                if($this->getItemFormat($item))
                {
                    $properties->{$key}->format = $this->getItemFormat($item);
                }

                switch ($properties->{$key}->type) {
                    case "array":
                        $properties->{$key}->items = $this->parseArray($item);
                        break;
                    case "object":
                        $properties->{$key}->properties = $this->parseObject($item);
                        break;
                    default:
                        $properties->{$key}->example = $item;
                }
            }
        }

        $schema->properties = $properties;

        return $schema;
    }

    private function parseArray($items)
    {
        $properties = new \stdClass();
        foreach ($items as $key => $item)
        {
            switch ($this->myGetDatatype(json_decode(json_encode($item)))) {
                case "object":
                    $properties = $this->getBodyContent($item);
                    break;
                default:
                    $properties->type = $this->myGetDatatype(json_decode(json_encode($item)));
            }
        }
        return $properties;
    }

    private function parseObject($items)
    {
        $properties = new \stdClass();

        foreach ($items as $key => $item)
        {
            if(!is_null($item) && isset($item))
            {
                $properties->{$key} = new \stdClass();

                $properties->{$key}->type = $this->myGetDataType(json_decode(json_encode($item)));
                $properties->{$key}->description = 'Parameter Description';

                if($this->getItemFormat($item))
                {
                    $properties->{$key}->format = $this->getItemFormat($item);
                }

                switch ($properties->{$key}->type) {
                    case "array":
                        $properties->{$key}->items = new \stdClass();
                        break;
                    case "object":
                        $properties->{$key}->properties = $this->parseObject($item);
                        break;
                    default:
                        $properties->{$key}->example = $item;
                }
            }
        }

        return $properties;
    }
}
