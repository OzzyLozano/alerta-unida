<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prueba de Pusher - Laravel 12</title>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f5f8fa;
      color: #333;
      line-height: 1.6;
      padding: 20px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    
    h1 {
      text-align: center;
      color: #2c5282;
      margin-bottom: 20px;
    }
    
    .status-container {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      padding: 10px;
      border-radius: 5px;
      background-color: #f8f9fa;
    }
    
    .status-indicator {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 10px;
    }
    
    .connecting {
      background-color: #ffc107;
    }
    
    .connected {
      background-color: #28a745;
    }
    
    .error {
      background-color: #dc3545;
    }
    
    .disconnected {
      background-color: #6c757d;
    }
    
    .controls {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    
    button {
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: 500;
    }
    
    .btn-connect {
      background-color: #28a745;
      color: white;
    }
    
    .btn-disconnect {
      background-color: #dc3545;
      color: white;
    }
    
    .btn-clear {
      background-color: #6c757d;
      color: white;
    }
    
    .messages-container {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 15px;
      max-height: 400px;
      overflow-y: auto;
      background-color: #f8f9fa;
    }
    
    .message {
      padding: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .message:last-child {
      border-bottom: none;
    }
    
    .message-time {
      font-size: 0.8em;
      color: #6c757d;
      margin-right: 8px;
    }
    
    .message-content {
      font-weight: 500;
    }
    
    .event-log {
      margin-top: 20px;
      padding: 15px;
      background-color: #f1f8ff;
      border-radius: 5px;
      border: 1px solid #d1e7ff;
    }
    
    .event-log h3 {
      margin-bottom: 10px;
      color: #2c5282;
    }
    
    .log-entry {
      font-family: monospace;
      font-size: 0.9em;
      padding: 5px;
      border-bottom: 1px dashed #d1e7ff;
    }
    
    .log-entry:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Prueba de Pusher - Laravel 12</h1>
    
    <div class="status-container">
      <div class="status-indicator connecting" id="statusIndicator"></div>
      <p id="statusText">Conectando...</p>
    </div>
    
    <div class="controls">
      <button class="btn-connect" id="connectBtn" disabled>Conectar</button>
      <button class="btn-disconnect" id="disconnectBtn">Desconectar</button>
      <button class="btn-clear" id="clearBtn">Limpiar mensajes</button>
    </div>
    
    <div class="messages-container" id="messages">
      <p class="message">Esperando mensajes...</p>
    </div>
    
    <div class="event-log">
      <h3>Registro de eventos</h3>
      <div id="eventLog"></div>
    </div>
  </div>

  <script>
    // Habilitar logging para debug
    Pusher.logToConsole = true;
    
    let pusher = null;
    let channel = null;
    const appKey = '62b33e980022bb9d0708';
    const cluster = 'us3';
    const channelName = 'my-channel';
    
    const statusIndicator = document.getElementById('statusIndicator');
    const statusText = document.getElementById('statusText');
    const messagesContainer = document.getElementById('messages');
    const eventLog = document.getElementById('eventLog');
    const connectBtn = document.getElementById('connectBtn');
    const disconnectBtn = document.getElementById('disconnectBtn');
    const clearBtn = document.getElementById('clearBtn');
    
    // Inicializar conexión
    connectPusher();
    
    function connectPusher() {
      logEvent('Iniciando conexión con Pusher...');
      updateStatus('connecting', 'Conectando...');
      
      try {
        pusher = new Pusher(appKey, {
          cluster: cluster,
          forceTLS: true
        });
        
        // Suscribirse al canal
        channel = pusher.subscribe(channelName);
        
        // Manejar eventos de suscripción
        channel.bind('pusher:subscription_succeeded', function() {
          logEvent('Suscripción al canal "' + channelName + '" exitosa');
          updateStatus('connected', 'Conectado al canal!');
          connectBtn.disabled = true;
          disconnectBtn.disabled = false;
        });
        
        channel.bind('pusher:subscription_error', function(status) {
          logEvent('Error en suscripción: ' + JSON.stringify(status));
          updateStatus('error', 'Error de suscripción: ' + status.error);
        });
        
        // Manejar eventos personalizados
        channel.bind('my-event', function(data) {
          logEvent('Evento recibido: my-event');
          addMessage(data);
        });
        
        channel.bind('App\\Events\\MyEvent', function(data) {
          logEvent('Evento recibido: App\\Events\\MyEvent');
          addMessage(data);
        });
        
        // Manejar eventos de conexión/desconexión de Pusher
        pusher.connection.bind('connected', function() {
          logEvent('Conexión establecida con Pusher');
        });
        
        pusher.connection.bind('disconnected', function() {
          logEvent('Desconectado de Pusher');
          updateStatus('disconnected', 'Desconectado');
          connectBtn.disabled = false;
          disconnectBtn.disabled = true;
        });
        
        pusher.connection.bind('error', function(err) {
          logEvent('Error de conexión: ' + JSON.stringify(err));
          updateStatus('error', 'Error de conexión');
        });
        
      } catch (error) {
        logEvent('Error al inicializar Pusher: ' + error.message);
        updateStatus('error', 'Error de inicialización: ' + error.message);
      }
    }
    
    function disconnectPusher() {
      if (pusher) {
        logEvent('Desconectando de Pusher...');
        pusher.disconnect();
        updateStatus('disconnected', 'Desconectado manualmente');
        connectBtn.disabled = false;
        disconnectBtn.disabled = true;
      }
    }
    
    function addMessage(data) {
      if (messagesContainer.querySelector('p').textContent === 'Esperando mensajes...') {
        messagesContainer.innerHTML = '';
      }
      
      const messageElement = document.createElement('div');
      messageElement.className = 'message';
      
      const timeElement = document.createElement('span');
      timeElement.className = 'message-time';
      timeElement.textContent = new Date().toLocaleTimeString();
      
      const contentElement = document.createElement('span');
      contentElement.className = 'message-content';
      contentElement.textContent = data.message || JSON.stringify(data);
      
      messageElement.appendChild(timeElement);
      messageElement.appendChild(contentElement);
      messagesContainer.appendChild(messageElement);
      
      // Auto-scroll to bottom
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    function updateStatus(status, text) {
      statusIndicator.className = 'status-indicator ' + status;
      statusText.textContent = text;
    }
    
    function logEvent(message) {
      const logEntry = document.createElement('div');
      logEntry.className = 'log-entry';
      logEntry.textContent = new Date().toLocaleTimeString() + ' - ' + message;
      eventLog.appendChild(logEntry);
      
      // Mantener un máximo de 50 entradas en el log
      if (eventLog.children.length > 50) {
        eventLog.removeChild(eventLog.firstChild);
      }
      
      // Auto-scroll to bottom
      eventLog.scrollTop = eventLog.scrollHeight;
    }
    
    // Event listeners para los botones
    connectBtn.addEventListener('click', function() {
      connectPusher();
    });
    
    disconnectBtn.addEventListener('click', function() {
      disconnectPusher();
    });
    
    clearBtn.addEventListener('click', function() {
      messagesContainer.innerHTML = '<p class="message">Esperando mensajes...</p>';
      logEvent('Mensajes limpiados');
    });
  </script>
</body>
</html>
