<?php
require_once(__DIR__ . '/RespostaRotas.php');

abstract class ControladorRotas{

    protected array $paramsUrl;
    protected array $request;
    protected array $headers;
    protected static object $response;

    public function __construct(array $paramsUrl,array $request,array $headers)
    {
        $this->paramsUrl = $paramsUrl;
        // print_r('<pre>');
        // print_r($paramsUrl);
        // print_r('</pre>');
        // exit;
        $this->request = $request;
        $this->headers = array_change_key_case($headers, CASE_LOWER);
        $accept        = $this->headers['accept'];
        if (empty($accept))$accept = '*/*';
        self::$response = new RespostaRotas($accept);
    }

    /**
     * Aplica codigo de retorno do método HTTP
     * @return void
     */
    protected function statusHttp($code)
    {
        self::$response->statusHttp($code);
    }
    /**
     * Adiciona um novo header de resposta para o cliente HTTP
     * @return void
     */
    protected function header($title, $content)
    {
        self::$response->headers($title, $content);
    }
    /**
     * Adicona o retorno da operação na memória para o cliente
     */
    protected function body(array|string $body): void
    {
        self::$response->body($body);
    }

    /**
     * Executa o verbo HTTP chamado
     * @return array|string|void
     */
    public function get()
    {
        $this->statusHttp(405);
        $this->body(array(
            'message' => 'Method Not implemented'
        ));
    }
    /**
     * Executa o verbo HTTP chamado
     * @return array|string|void
     */
    public function post()
    {
        $this->statusHttp(405);
        $this->body(array(
            'message' => 'Method Not implemented'
        ));
    }
    /**
     * Executa o verbo HTTP chamado
     * @return array|string|void
     */
    public function put()
    {
        $this->statusHttp(405);
        $this->body(array(
            'message' => 'Method Not implemented'
        ));
    }
    /**
     * Executa o verbo HTTP chamado
     * @return array|string|void
     */
    public function delete()
    {
        $this->statusHttp(405);
        $this->body(array(
            'message' => 'Method Not implemented'
        ));
    }
    /**
     * Método implementado por causa do axios em desenvolvimento que valida o acesso por meio do options
     *
     * @return void
     */
    public function options()
    {
        $this->statusHttp(200);
    }

    /**
     * Prepara e envia a resposta para o recurso solicitado
     * @param  string|array $error
     * @return void
     */
    public function response()
    {
        echo self::$response->response();
    }

    /**
     * Retorna Class para rota chamada pela API
     */
    public static function getInstance(string $route, array $request, string $diretorio, array $headers): object
    {
        if (empty($diretorio)) {
            throw new Exception('Diretório não definido');
        }
        if (preg_match('/\/$/', $diretorio)) {
            $diretorio = substr($diretorio, 0, -1);
        }
        list($rota, $params) = self::registerRoute($route);
        // print_r('<pre>');
        // var_dump($rota);
        // print_r('</pre>');
        // print_r('<pre>');
        // print_r($diretorio . "/{$rota}.php");
        // print_r('</pre>');
        // exit;
        if (!file_exists($diretorio . "/{$rota}.php")) {
            throw new Exception("Rota não encontrada: " . $rota, 404);
        }
        require_once($diretorio . "/{$rota}.php");
        if (!class_exists($rota)) {
            throw new Exception("Classe não encontrada: {$rota}", 404);
        }
        return new $rota($params, $request, $headers);
    }

    /**
     * Método responsável por tratar chamadas de rotas com parâmetros
     */
    protected static function registerRoute(string &$route): array
    {
        $params = explode('/', substr($route, 1));
        list($rota) = $params;
        if (empty($rota)) {
            throw new Exception("Rota inválida: {$route}");
        }
        $rota = ucfirst(strtolower($rota));
        if (strpos($rota, '-') !== false) {
            $concact = explode('-', $rota);
            $concact = array_map('ucfirst', $concact);
            $rota    = implode('', $concact);
        }
        array_shift($params); // removendo a rota do array
        return array($rota, $params);
    }
}
?>