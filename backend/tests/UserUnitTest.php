<?php
require_once 'backend/models/User.php';

use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase {
    private $dbMock;
    private $user;

    protected function setUp(): void {
        // Cria um mock da classe PDO (simula a conexão com o banco de dados)
        $this->dbMock = $this->createMock(PDO::class);
        $this->user = new User($this->dbMock);
    }

    public function testEmailExists(): void {
        // Mock para o caso de e-mail existente
        $stmtMockExists = $this->createMock(\PDOStatement::class);
        $stmtMockExists->method('rowCount')->willReturn(1);
    
        // Mock para o caso de e-mail inexistente
        $stmtMockNotExists = $this->createMock(\PDOStatement::class);
        $stmtMockNotExists->method('rowCount')->willReturn(0);
    
        // Mock do PDO para retornar diferentes statements em chamadas consecutivas
        $this->dbMock->method('prepare')
            ->will($this->onConsecutiveCalls($stmtMockExists, $stmtMockNotExists));
    
        // Configurando o e-mail no objeto User
        $this->user->email = "test@example.com";
    
        // Caso 1: E-mail existe
        $this->assertTrue($this->user->emailExists(), "Falha ao detectar que o e-mail existe.");
    
        // Caso 2: E-mail não existe
        $this->assertFalse($this->user->emailExists(), "Falha ao detectar que o e-mail não existe.");
    }
    
    public function testCreate(): void {
        // Configura os valores do objeto User
        $this->user->email = "new@example.com";
        $this->user->name = "New User";
        $this->user->password = "password";
    
        // Cria um mock para simular o comportamento do PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
    
        // Configura o mock do PDO para retornar o mock do PDOStatement quando 'prepare' for chamado
        $this->dbMock->method('prepare')->willReturn($stmtMock);
    
        // Verifica se o método 'create' retorna 'true', indicando que o usuário foi criado com sucesso
        $this->assertTrue($this->user->create());
    }    
}
?>