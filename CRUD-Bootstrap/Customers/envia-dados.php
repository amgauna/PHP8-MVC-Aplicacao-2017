public function insert()
        {
            try{
            $sql = "INSERT INTO $this->tabela (nva_nome, nva_incluir, nva_excluir, nva_visualizar, nva_dataCad, nva_status) VALUES (:nva_nome, :nva_incluir, :nva_excluir, :nva_visualizar, :nva_dataCad, :nva_status)";
     
            $stm = DB::prepare($sql);
            //substituir
            $stm->bindValue(':nva_nome', $this->getNva_nome());
            $stm->bindValue(':nva_incluir', $this->getNva_incluir());
            $stm->bindValue(':nva_excluir', $this->getNva_excluir());
            $stm->bindValue(':nva_visualizar', $this->getNva_visualizar());
            $stm->bindValue(':nva_dataCad', $this->getNva_dataCad());
            $stm->bindValue(':nva_status', $this->getNva_status());
            
            //Gravando o log
            DB::setLogger(new TLoggerTXT('./tmp/arquivo.txt'));//grava o rquivo de log
            DB::log("Inserindo registro");
            DB::log($sql);
         
            return $stm->execute();
         
		              $var->insert();

                      header();
		 
                    //  header('Location: cadFuncoes.php');
                    //  die();
            
        
    
            } catch (ErrorException $ex)
            {
                echo "Erro : ".$ex->getMessage();
            }
          
                    
        }