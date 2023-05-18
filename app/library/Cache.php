<?php

namespace app\library;

/**
 * Está é a penas para ser lida
 * 
 * Funciona apneas no PHP 8.2 versões anteriores quebrará o código.
 * 
 * vc pode desacoplá-la se assim desejar
 * 
 * @author David Teixeira Pereira Ferreira <avraham_peretz@hotmail.com> * 
 * 
 */
readonly class Cache
{

    public function __construct(private string $name){}

    private function createAndReturn(string $cacheName, string|array $data)
    {       
        file_put_contents($cacheName, $data);
        return json_decode($data);
    }

    /**
     * |Cria um cache em um arquivo txt no diretório acessível
     * 
     * este metodo tem por padrão 10 minutos de validade, 
     * vc pode alterá-lo na chamado do mesmo em se segundo paramtro.
     * 
     * Este método retorna um json decodificado em um array ou uma string de acordo com que vc desejar
     *
     * @param string|array $data
     * @param integer $validateInMinutes
     * @return array|string
     */
    public function create(string|array $data, int $validateInMinutes = 10)
    {
        $data = json_encode($data);

        $cacheName = $this->name . '.txt';
        if (file_exists($cacheName)) {
            $fileCreated = filemtime($cacheName);
            $expired = strtotime("+{$validateInMinutes} minutes", $fileCreated) < strtotime('now');
            if ($expired)return $this->createAndReturn($cacheName, $data);

            return json_decode(file_get_contents($cacheName));
        } else {
            return $this->createAndReturn($cacheName, $data);
        }
    }
}
