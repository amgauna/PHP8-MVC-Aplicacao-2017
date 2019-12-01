
Configurar o PHP em aplicativos Web do Serviço de Aplicativo do Microsoft Azure

https://docs.microsoft.com/pt-br/azure/app-service-web/web-sites-php-configure


2017-4-25 7 mínimo a ler Colaboradores  Robert McMurray  OpenLocalizationService  Sunny Deng  lucasfmo  v-sacor tudo

Introdução

Este guia mostrará como configurar o tempo de execução do PHP interno para aplicativos Web no Serviço de Aplicativo 
do Azure, fornecer um tempo de execução personalizado do PHP e habilitar extensões. Para usar o Serviço de Aplicativo, 
inscreva-se para a avaliação gratuita. Para aproveitar ao máximo este guia, você deve primeiro criar um aplicativo Web 
do PHP no Serviço de Aplicativo.

Observação

Embora este artigo esteja relacionado a aplicativos Web, ele também serve para aplicativos de API e aplicativos móveis.
Como: alterar a versão interna do PHP
Por padrão, quando você cria um aplicativo Web do Serviço de Aplicativo, o PHP 5.5 é instalado e fica imediatamente 
disponível para uso. A melhor forma de visualizar a revisão da versão, sua configuração padrão e as extensões habilitadas 
é implantar um script que chame a função phpinfo() .
As versões 5.6 e 7.0 do PHP também estão disponíveis, mas não são habilitadas por padrão. Para atualizar a versão do PHP, 
execute um destes métodos:

Portal do Azure

Navegue até seu aplicativo Web no Portal do Azure e clique no botão Configurações .
Configurações do aplicativo Web
Na folha Configurações, selecione Configurações do aplicativo e escolha a nova versão do PHP.
Configurações do aplicativo
Clique no botão Salvar na parte superior da folha Configurações do aplicativo Web.
Salvar definições de configuração
PowerShell do Azure (Windows)

Abra o Azure PowerShell e faça logon em sua conta:
Code
 Copy
 PS C:\> Login-AzureRmAccount
Defina a versão PHP do aplicativo Web.
Code
 Copy
 PS C:\> Set-AzureWebsite -PhpVersion {5.5 | 5.6 | 7.0} -Name {app-name}
A versão do PHP agora está definida. Você pode confirmar essas configurações:
Code
 Copy
 PS C:\> Get-AzureWebsite -Name {app-name} | findstr PhpVersion
Interface de linha de comando do Azure (Linux, Mac, Windows)

Para usar a Interface de Linha de Comando do Azure, é necessário ter Node.js instalado no computador.
Abra o Terminal e faça logon em sua conta.
Code
 Copy
 azure login
Defina a versão PHP do aplicativo Web.
Code
 Copy
 azure site set --php-version {5.5 | 5.6 | 7.0} {app-name}
A versão do PHP agora está definida. Você pode confirmar essas configurações:
Code
 Copy
 azure site show {app-name}
Observação

Os comandos da CLI 2.0 do Azure equivalentes aos mencionados acima são:

Code
 Copy
az login
az appservice web config update --php-version {5.5 | 5.6 | 7.0} -g {resource-group-name} -n {app-name}
az appservice web config show -g {resource-group-name} -n {app-name}

Como: alterar as configurações internas do PHP

Para qualquer tempo de execução interno do PHP, é possível alterar qualquer uma das opções de configuração seguindo 
as etapas abaixo. (Para obter informações sobre diretrizes de php. ini, consulte Lista de diretrizes de php. ini.)
Alterando as configurações de PHP_INI_USER, PHP_INI_PERDIR e PHP_INI_ALL

Adicione um arquivo .user.ini no seu diretório raiz.
Adicione as definições de configuração ao arquivo .user.ini usando a mesma sintaxe que você usaria em um arquivo php.ini. 
Por exemplo, se você quisesse ativar a configuração display_errors e definir a configuração upload_max_filesize como 10 M, 
o arquivo .user.ini conteria este texto:

Code
 Copy
 ; Example Settings
 display_errors=On
 upload_max_filesize=10M

 ; OPTIONAL: Turn this on to write errors to d:\home\LogFiles\php_errors.log
 ; log_errors=On
 
Implante seu aplicativo Web.

Reinicie o aplicativo Web. (É necessário reiniciar, pois a frequência com a qual o PHP lê arquivos .user.ini é regida pela
configuraçãouser_ini.cache_ttl, que é uma configuração de nível de sistema e é, por padrão, 300 segundos (5 minutos). 
Reiniciar o aplicativo Web força o PHP a ler as novas configurações no arquivo .user.ini ).
Uma alternativa ao uso de um arquivo .user.ini é usar a função ini_set() em scripts para definir opções de configuração que 
não sejam diretrizes de nível de sistema.

Alterando as configurações de PHP_INI_SYSTEM

Adicionar uma Configuração de Aplicativo a seu aplicativo Web com a chave PHP_INI_SCAN_DIR e o valor d:\home\site\ini
Crie um arquivo settings.ini usando o console Kudu (http://<nome-do-site>.scm.azurewebsite.net) no diretório d:\home\site\ini.
Adicione as definições de configuração ao arquivo settings.ini usando a mesma sintaxe que você usaria em um arquivo php.ini. 
Por exemplo, se você quisesse apontar a configuração curl.cainfo para um arquivo *.crt e definir a configuração 
'wincache.maxfilesize' como 512 K, o arquivo settings.ini conteria este texto:

Code
 Copy
 ; Example Settings
 curl.cainfo="%ProgramFiles(x86)%\Git\bin\curl-ca-bundle.crt"
 wincache.maxfilesize=512
 
Reinicie seu aplicativo Web para carregar as alterações.

Como: habilitar extensões no tempo de execução padrão do PHP

Conforme indicado na seção anterior, a melhor forma de visualizar a versão padrão do PHP, sua configuração padrão e as extensões 
habilitadas é implantar um script que chame phpinfo(). Para habilitar extensões adicionais, siga as etapas abaixo:
Configurar por meio de configurações ini

Adicione um diretório ext ao diretório d:\home\site.
Coloque arquivos de extensão .dll no diretório ext (por exemplo, php_xdebug.dll). Certifique-se de que as extensões sejam compatíveis
com a versão padrão do PHP e também com nts (non-thread-safe) e VC9.

Adicionar uma Configuração de Aplicativo a seu aplicativo Web com a chave PHP_INI_SCAN_DIR e o valor d:\home\site\ini
Crie um arquivo ini em d:\home\site\ini chamado extensions.ini.

Adicione as definições de configuração ao arquivo extensions.ini usando a mesma sintaxe que você usaria em um arquivo php.ini. 
Por exemplo, se você desejasse habilitar as extensões MongoDB e XDebug, o arquivo extensions.ini conteria este texto:

Code
 Copy
 ; Enable Extensions
 extension=d:\home\site\ext\php_mongo.dll
 zend_extension=d:\home\site\ext\php_xdebug.dll
 
Reinicie seu aplicativo Web para carregar as alterações.

Configurar por meio de Configuração de Aplicativo

Adicione um diretório bin ao diretório raiz.
Coloque arquivos de extensão .dll no diretório bin (por exemplo, php_xdebug.dll). Certifique-se de que as extensões sejam 
compatíveis com a versão padrão do PHP e também com nts (non-thread-safe) e VC9.

Implante seu aplicativo Web.
Navegue até o aplicativo Web no Portal do Azure e clique no botão Configurações .
Configurações do aplicativo Web
Na folha Configurações, selecione Configurações do Aplicativo e role até a seção Configurações do Aplicativo.
Na seção Configurações do aplicativo, crie uma chave PHP_EXTENSIONS. O valor para essa chave seria um caminho relativo
 à raiz do site: bin\seu-arquivo-de-ext.
 
Habilitar extensões em configurações do aplicativo
Clique no botão Salvar na parte superior da folha Configurações do aplicativo Web.
Salvar definições de configuração

Também há suporte para extensões Zend usando uma chave PHP_ZENDEXTENSIONS. Para habilitar várias extensões, inclua uma lista 
de arquivos .dll separados por vírgulas para o valor de configuração do aplicativo.

Como: usar um tempo de execução personalizado do PHP

Em vez do tempo de execução padrão do PHP, os aplicativos Web do Serviço de Aplicativo podem usar um tempo de execução de PHP 
fornecido por você para executar scripts PHP. O tempo de execução que você fornece pode ser configurado por um arquivo php.ini 
também fornecido por você. Para usar um tempo de execução personalizado do PHP com aplicativos Web, siga as etapas abaixo.
Obtenha uma versão do PHP ou VC11 para Windows que seja não thread safe e compatível com a versão VC9. Versões recentes do PHP 
para Windows podem ser encontradas aqui: http://windows.php.net/download/. Versões mais antigas podem ser encontradas neste 
arquivo morto: http://windows.php.net/downloads/releases/archives/.

Modifique o arquivo php.ini para o seu tempo de execução. Observe que quaisquer definições de configuração que forem diretrizes 
exclusivamente de nível de sistema serão ignoradas por Aplicativos Web. (Para informações sobre diretrizes de nível de sistema 
apenas, consulte Lista de diretrizes de php. ini.)

Opcionalmente, adicione extensões para o seu tempo de execução do PHP e habilite-as no arquivo php.ini .

Adicione o diretório bin ao seu diretório raiz e coloque lá o diretório que contém o seu tempo de execução do PHP (por exemplo, bin\php).

Implante seu aplicativo Web.
Navegue até o aplicativo Web no Portal do Azure e clique no botão Configurações .

Configurações do aplicativo Web
Na folha Configurações, selecione Configurações do Aplicativo e role até a seção Mapeamentos de manipulador. Adicione *.php ao campo 
Extensão e adicionar o caminho para o executável php-cgi.exe. Se você colocar seu tempo de execução do PHP no diretório bin na raiz 
do aplicativo, o caminho será D:\home\site\wwwroot\bin\php\php-cgi.exe.

Especificar o manipulador em mapeamentos de manipulador
Clique no botão Salvar na parte superior da folha Configurações do aplicativo Web.
Salvar definições de configuração

Como habilitar a automação do Criador no Azure
Por padrão, o Serviço de Aplicativo não fará nada com o composer.json se você tiver um em seu projeto PHP. Se você usar a implantação
 Git, você poderá habilitar o composer.json durante o git push habilitando a extensão do Criador.
Observação

Você pode votar para obter o suporte de primeira classe do Criador no Serviço de Aplicativo aqui.
Na folha do aplicativo Web PHP no portal do Azure, clique em Ferramentas > Extensões.
Folha de configurações do Portal do Azure para habilitar a automação do Criador no Azure
Clique em Adicionar e em Criador.
Adicionar extensão do Criador para habilitar sua respectiva automação no Azure
Clique em OK para aceitar os termos legais. Clique em OK novamente para adicionar a extensão.
Agora, a folha Extensões instaladas mostrará a Extensão do criador.
Aceite os termos legais para habilitar a automação do Criador no Azure
Agora, execute git add, git commit e git push como na seção anterior. Agora, você verá que o Compositor está instalando dependências 
definidas no composer.json.
Implantação do Git com a automação do Criador no Azure
Próximas etapas
Para obter mais informações, veja o Centro de Desenvolvimento PHP.
Observação

Se você deseja começar a usar o Serviço de Aplicativo do Azure antes de se inscrever em uma conta do Azure, vá até Experimentar o 
Serviço de Aplicativo, em que você pode criar imediatamente um aplicativo Web inicial de curta duração no Serviço de Aplicativo. 
Nenhum cartão de crédito é exigido, sem compromissos.
