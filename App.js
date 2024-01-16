// src/App.js
import React, { useState } from 'react';
import axios from 'axios';

function App() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [fullName, setFullName] = useState('');
  const [message, setMessage] = useState('');
  const [userLoggedIn, setUserLoggedIn] = useState(false);
  const [showCadastro, setShowCadastro] = useState(false);

  const handleLogin = async () => {
    try {
      const response = await axios.post('http://localhost/LOJA_DE_ROUPA/auth.php', { username, password });

      if (response.data.success) {
        setMessage(`Olá, ${username}! Login bem-sucedido.`);
        setUserLoggedIn(true);
      } else {
        setMessage(response.data.message || 'Erro desconhecido');
      }
    } catch (error) {
      console.error('Erro de rede', error);
      setMessage('Erro de rede. Verifique a conexão.');
    }
  };

  const handleCadastro = async () => {
    try {
      const response = await axios.post('http://localhost/LOJA_DE_ROUPA/cadastro.php', {
        username,
        password,
        email,
        phone,
        fullName,
      });

      setMessage(response.data.message || 'Erro desconhecido');
    } catch (error) {
      console.error('Erro de rede', error);
      setMessage('Erro de rede. Verifique a conexão.');
    }
  };

  const renderCadastro = () => (
    <div>
      <h1>Cadastro</h1>
      <label>Nome de Usuário:</label>
      <input type="text" onChange={(e) => setUsername(e.target.value)} />
      <label>Senha:</label>
      <input type="password" onChange={(e) => setPassword(e.target.value)} />
      <label>Email:</label>
      <input type="text" onChange={(e) => setEmail(e.target.value)} />
      <label>Telefone:</label>
      <input type="text" onChange={(e) => setPhone(e.target.value)} />
      <label>Nome Completo:</label>
      <input type="text" onChange={(e) => setFullName(e.target.value)} />
      <button onClick={handleCadastro}>Cadastrar</button>
    </div>
  );

  const homePage = () => (
    <div style={{ textAlign: 'center', marginTop: '50px' }}>
      <h2>Olá, {username}!</h2>
    </div>
  );

  return (
    <div>
      {userLoggedIn ? (
        homePage()
      ) : (
        <div>
          <h1>Login</h1>
          <input type="text" placeholder="Nome de usuário" onChange={(e) => setUsername(e.target.value)} />
          <input type="password" placeholder="Senha" onChange={(e) => setPassword(e.target.value)} />
          {message && <p style={{ color: message.includes('sucesso') ? 'green' : 'red' }}>{message}</p>}
          <button onClick={handleLogin}>Entrar</button>

          <button onClick={() => setShowCadastro(true)}>Cadastre-se</button>
        </div>
      )}

      {showCadastro && renderCadastro()}
    </div>
  );
}

export default App;
