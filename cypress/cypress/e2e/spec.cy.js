describe('Frontend Validation', () => {
    beforeEach(() => {
      // Carrega o frontend antes de cada teste
      cy.visit('http://localhost');
    });
  
    it('validando todos os elementos principais da página', () => {
      // Verifica se os elementos principais estão visíveis
      cy.get('h1').contains('Cadastro de Usuários').should('be.visible');
      cy.get('form#registerForm').should('be.visible');
      cy.get('input#name').should('exist');
      cy.get('input#email').should('exist');
      cy.get('input#password').should('exist');
      cy.get('button[type="submit"]').contains('Registrar').should('be.visible');
      cy.get('button#loadUsers').contains('Carregar Usuários').should('be.visible');
      cy.get('ul#userList').should('exist');
    });
  
  });
  