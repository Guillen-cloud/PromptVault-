<!-- Botón Flotante Minimalista -->
<button id="asistenteBtn" class="asistente-btn-min" onclick="toggleAsistente()" title="Asistente IA">
    <i class="fas fa-robot"></i>
</button>

<!-- Modal Minimalista -->
<div id="asistenteModal" class="asistente-modal-min">
    <div class="asistente-min-container">
        <div class="asistente-min-header">
            <span class="asistente-min-title"><i class="fas fa-robot"></i> Asistente IA</span>
            <button class="asistente-min-close" onclick="toggleAsistente()" title="Cerrar"><i class="fas fa-times"></i></button>
        </div>
        <div class="asistente-min-tabs">
            <button class="min-tab active" data-mode="general">General</button>
            <button class="min-tab" data-mode="generar">Generar</button>
            <button class="min-tab" data-mode="optimizar">Optimizar</button>
            <button class="min-tab" data-mode="ayuda">Ayuda</button>
        </div>
        <div id="chatMessages" class="asistente-min-messages">
            <div class="asistente-min-welcome">¡Hola! ¿En qué te ayudo hoy?</div>
        </div>
        <div class="asistente-min-quick">
            <button onclick="enviarMensajeRapido('Prompt para RRSS')">Prompt para RRSS</button>
            <button onclick="enviarMensajeRapido('Análisis de datos')">Análisis de datos</button>
            <button onclick="enviarMensajeRapido('Optimizar prompt')">Optimizar</button>
        </div>
        <div class="asistente-min-input">
            <textarea id="mensajeAsistente" placeholder="Escribe tu mensaje..." maxlength="1000" rows="1"></textarea>
            <button id="enviarBtn" onclick="enviarMensaje()" disabled><i class="fas fa-paper-plane"></i></button>
            <span id="charCounter" class="asistente-min-counter">0/1000</span>
        </div>
    </div>
</div>

<style>
.asistente-btn-min {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #fff;
    color: #6366f1;
    border: 1.5px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    z-index: 999;
    transition: box-shadow 0.2s, color 0.2s;
}
.asistente-btn-min:hover {
    color: #4f46e5;
    box-shadow: 0 4px 16px rgba(99,102,241,0.10);
}

.asistente-modal-min {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 370px;
    max-width: 95vw;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.10);
    border: 1.5px solid #e5e7eb;
    display: none;
    flex-direction: column;
    z-index: 1000;
    overflow: hidden;
}
.asistente-modal-min.active { display: flex; }
.asistente-min-container { display: flex; flex-direction: column; height: 100%; }
.asistente-min-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.1rem 1.3rem 0.7rem 1.3rem;
    border-bottom: 1px solid #e5e7eb;
    background: #fff;
}
.asistente-min-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #6366f1;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.asistente-min-close {
    background: none;
    border: none;
    color: #9ca3af;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.2rem 0.4rem;
    border-radius: 6px;
    transition: background 0.2s;
}
.asistente-min-close:hover { background: #f3f4f6; color: #6366f1; }
.asistente-min-tabs {
    display: flex;
    gap: 0.5rem;
    padding: 0.7rem 1.3rem 0.7rem 1.3rem;
    border-bottom: 1px solid #e5e7eb;
    background: #fff;
}
.min-tab {
    flex: 1;
    background: none;
    border: none;
    border-bottom: 2.5px solid transparent;
    color: #6b7280;
    font-size: 0.98rem;
    font-weight: 500;
    padding: 0.4rem 0;
    cursor: pointer;
    transition: color 0.2s, border-color 0.2s;
}
.min-tab.active {
    color: #6366f1;
    border-bottom: 2.5px solid #6366f1;
    font-weight: 600;
}
.asistente-min-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1.2rem 1.3rem 1.2rem 1.3rem;
    background: #fff;
    font-size: 0.98rem;
    color: #222;
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}
.asistente-min-welcome {
    color: #6366f1;
    font-weight: 500;
    text-align: center;
    margin: 1.5rem 0 0.5rem 0;
}
.asistente-min-quick {
    display: flex;
    gap: 0.5rem;
    padding: 0.5rem 1.3rem 0.5rem 1.3rem;
    background: #fff;
}
.asistente-min-quick button {
    background: none;
    border: 1.2px solid #e5e7eb;
    color: #6366f1;
    font-size: 0.93rem;
    border-radius: 14px;
    padding: 0.35rem 0.9rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}
.asistente-min-quick button:hover {
    background: #f3f4f6;
    color: #4f46e5;
}
.asistente-min-input {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.3rem 1.1rem 1.3rem;
    border-top: 1px solid #e5e7eb;
    background: #fff;
}
.asistente-min-input textarea {
    flex: 1;
    border: none;
    border-bottom: 1.5px solid #e5e7eb;
    font-size: 1rem;
    resize: none;
    outline: none;
    background: transparent;
    color: #222;
    padding: 0.4rem 0.2rem;
    min-height: 32px;
    max-height: 80px;
    transition: border-color 0.2s;
}
.asistente-min-input textarea:focus {
    border-bottom: 1.5px solid #6366f1;
}
.asistente-min-input button {
    background: none;
    border: none;
    color: #6366f1;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0.3rem 0.5rem;
    border-radius: 8px;
    transition: background 0.2s, color 0.2s;
}
.asistente-min-input button:disabled {
    color: #c7d2fe;
    cursor: not-allowed;
}
.asistente-min-input button:hover:not(:disabled) {
    background: #f3f4f6;
    color: #4f46e5;
}
.asistente-min-counter {
    font-size: 0.82rem;
    color: #9ca3af;
    margin-left: 0.5rem;
}
@media (max-width: 600px) {
    .asistente-modal-min {
        right: 0.5rem;
        left: 0.5rem;
        width: auto;
        min-width: unset;
        max-width: 98vw;
    }
    .asistente-btn-min {
        right: 1rem;
        bottom: 1rem;
    }
}
</style>

/* Modal del Asistente - Diseño Profesional */
.asistente-modal {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 480px;
    max-height: 720px;
    height: calc(100vh - 4rem);
    max-height: 720px;
    background: var(--bg-white);
    border-radius: 24px;
    box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    z-index: 1000;
    overflow: hidden;
    border: 1px solid var(--border-color);
    backdrop-filter: blur(10px);
}

.asistente-modal.active {
    display: flex;
    animation: slideUpFadeIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes slideUpFadeIn {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.asistente-container {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: linear-gradient(to bottom, var(--bg-white) 0%, var(--bg-light) 100%);
}

/* Header Profesional con Gradiente */
.asistente-header {
    background: var(--primary-gradient);
    color: white;
    padding: 0;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    position: relative;
    overflow: hidden;
}

.asistente-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.5;
}

.header-top {
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.asistente-title {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-icon {
    position: relative;
    width: 52px;
    height: 52px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.status-indicator {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 16px;
    height: 16px;
    background: var(--success-color);
    border: 3px solid white;
    border-radius: 50%;
    animation: pulseStatus 2s ease-in-out infinite;
}

@keyframes pulseStatus {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.title-content h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    letter-spacing: -0.3px;
}

.pro-badge {
    display: inline-block;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    font-size: 0.625rem;
    font-weight: 800;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
}

.title-content p {
    margin: 0.25rem 0 0 0;
    font-size: 0.8125rem;
    opacity: 0.95;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-weight: 500;
}

.online-status {
    font-size: 0.5rem;
    color: var(--success-color);
    filter: drop-shadow(0 0 4px var(--success-color));
    animation: blink 2s ease-in-out infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.asistente-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    font-size: 0.95rem;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

.close-btn:hover {
    background: rgba(239, 68, 68, 0.9);
    border-color: rgba(239, 68, 68, 1);
}

/* Mode Selector - Diseño de Tabs Moderno */
.mode-selector {
    padding: 1rem 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 1;
}

.mode-tabs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.5rem;
}

.mode-tab {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.625rem 0.5rem;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    backdrop-filter: blur(10px);
}

.mode-tab i {
    font-size: 1.1rem;
}

.mode-tab:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

.mode-tab.active {
    background: white;
    color: var(--primary-color);
    border-color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Messages Area - Diseño Profesional */
.asistente-messages {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    background: linear-gradient(to bottom, #fafafa 0%, #ffffff 100%);
}

/* Welcome Card Profesional */
.welcome-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
    text-align: center;
}

.welcome-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.25rem;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
    animation: welcomeFloat 3s ease-in-out infinite;
}

@keyframes welcomeFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

.welcome-card h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    letter-spacing: -0.5px;
}

.welcome-subtitle {
    margin: 0 0 1.75rem 0;
    font-size: 0.9rem;
    color: var(--text-medium);
    font-weight: 500;
}

.capabilities-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.capability-item {
    background: var(--bg-light);
    border: 2px solid var(--border-color);
    border-radius: 14px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    text-align: left;
}

.capability-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-color);
}

.capability-icon {
    width: 42px;
    height: 42px;
    background: var(--primary-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.capability-text {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.capability-text strong {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--text-dark);
}

.capability-text span {
    font-size: 0.75rem;
    color: var(--text-medium);
    line-height: 1.3;
}

.welcome-cta {
    padding-top: 1.5rem;
    border-top: 2px solid var(--border-color);
}

.welcome-cta p {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
}

/* Message Bubbles Profesionales */
.message {
    display: flex;
    gap: 0.875rem;
    animation: messageSlideIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes messageSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.message-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.asistente-message .message-avatar {
    background: var(--primary-gradient);
    color: white;
    border: 3px solid white;
}

.user-message {
    flex-direction: row-reverse;
}

.user-message .message-avatar {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: 3px solid white;
}

.message-content {
    flex: 1;
    max-width: 75%;
}

.user-message .message-content {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.message-text {
    background: white;
    padding: 1rem 1.25rem;
    border-radius: 18px;
    font-size: 0.9375rem;
    line-height: 1.7;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    white-space: pre-line;
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

.user-message .message-text {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-color: transparent;
}

.message-text strong {
    font-weight: 700;
}

.message-text code {
    background: var(--bg-secondary);
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    font-family: 'Fira Code', 'Courier New', monospace;
    font-size: 0.85rem;
    border: 1px solid var(--border-color);
}

.user-message .message-text code {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
}

.message-time {
    font-size: 0.7rem;
    color: var(--text-light);
    margin-top: 0.4rem;
    font-weight: 500;
}

/* Typing Indicator Profesional */
.typing-indicator {
    display: flex;
    gap: 0.375rem;
    padding: 1rem 1.25rem;
    background: white;
    border-radius: 18px;
    width: fit-content;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
}

.typing-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--primary-gradient);
    animation: typingBounce 1.4s infinite ease-in-out;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typingBounce {
    0%, 60%, 100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    30% {
        transform: translateY(-12px) scale(1.1);
        opacity: 1;
    }
}

/* Input Area Profesional */
.asistente-input-area {
    padding: 1.25rem;
    background: white;
    border-top: 1px solid var(--border-color);
}

.quick-actions-top {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    overflow-x: auto;
    padding-bottom: 0.25rem;
}

.quick-actions-top::-webkit-scrollbar {
    height: 3px;
}

.quick-actions-top::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 3px;
}

.quick-action-chip {
    background: var(--bg-light);
    border: 1.5px solid var(--border-color);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-dark);
}

.quick-action-chip:hover {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.quick-action-chip i {
    font-size: 0.95rem;
}

.input-container {
    background: white;
}

.input-wrapper {
    background: var(--bg-light);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    padding: 0.875rem 1rem;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    align-items: flex-end;
    gap: 0.75rem;
}

.input-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: white;
}

.asistente-input {
    flex: 1;
    border: none;
    background: transparent;
    resize: none;
    font-size: 0.9375rem;
    line-height: 1.6;
    max-height: 140px;
    outline: none;
    color: var(--text-dark);
    font-family: inherit;
}

.asistente-input::placeholder {
    color: var(--text-light);
}

.send-btn {
    background: var(--primary-gradient);
    color: white;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    font-size: 1.1rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.send-btn:hover:not(:disabled) {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
}

.send-btn:active:not(:disabled) {
    transform: translateY(0) scale(0.95);
}

.send-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    box-shadow: none;
}

.input-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.75rem;
    padding: 0 0.25rem;
}

.char-counter {
    font-size: 0.75rem;
    color: var(--text-light);
    font-weight: 600;
}

.input-hint {
    font-size: 0.7rem;
    color: var(--text-light);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.input-hint i {
    font-size: 0.65rem;
}

/* Footer Profesional */
.asistente-footer {
    padding: 0.875rem 1.5rem;
    background: var(--bg-light);
    border-top: 1px solid var(--border-color);
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.75rem;
    color: var(--text-medium);
}

.powered-by {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-weight: 600;
}

.powered-by i {
    color: var(--primary-color);
    font-size: 0.85rem;
}

.powered-by strong {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-status {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.footer-status i {
    color: var(--success-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .asistente-modal {
        width: calc(100vw - 2rem);
        max-width: 100%;
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
        max-height: calc(100vh - 10rem);
    }

    .asistente-btn {
        bottom: 1.5rem;
        right: 1.5rem;
        width: 60px;
        min-width: 60px;
        padding: 0;
    }

    .btn-text {
        display: none;
    }

    .mode-tabs {
        grid-template-columns: repeat(4, 1fr);
        gap: 0.35rem;
    }

    .mode-tab {
        padding: 0.5rem 0.25rem;
        font-size: 0.7rem;
    }

    .mode-tab i {
        font-size: 1rem;
    }

    .capabilities-grid {
        grid-template-columns: 1fr;
    }

    .welcome-card {
        padding: 1.5rem;
    }

    .message-content {
        max-width: 85%;
    }
}

@media (max-width: 480px) {
    .mode-tab span {
        font-size: 0.65rem;
    }

    .header-top {
        padding: 1.25rem;
    }

    .title-icon {
        width: 44px;
        height: 44px;
        font-size: 1.5rem;
    }

    .title-content h3 {
        font-size: 1.1rem;
    }

    .quick-action-chip {
        font-size: 0.75rem;
        padding: 0.45rem 0.85rem;
    }
}

/* Scrollbar Personalizado */
.asistente-messages::-webkit-scrollbar {
    width: 8px;
}

.asistente-messages::-webkit-scrollbar-track {
    background: var(--bg-light);
    border-radius: 10px;
}

.asistente-messages::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
    border-radius: 10px;
}

.asistente-messages::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, var(--primary-dark), var(--primary-color));
}

/* Dark mode support (opcional) */
@media (prefers-color-scheme: dark) {
    :root {
        --bg-white: #1f2937;
        --bg-light: #111827;
        --bg-secondary: #374151;
        --text-dark: #f9fafb;
        --text-medium: #d1d5db;
        --text-light: #9ca3af;
        --border-color: #374151;
    }
}
</style>

<script>
// Toggle asistente modal
function toggleAsistente() {
    const modal = document.getElementById('asistenteModal');
    const btn = document.getElementById('asistenteBtn');
    
    modal.classList.toggle('active');
    
    // Ocultar botón cuando modal está abierto
    if (modal.classList.contains('active')) {
        btn.style.display = 'none';
        // Hacer focus en el input
        setTimeout(() => {
            document.getElementById('mensajeAsistente').focus();
        }, 300);
    } else {
        btn.style.display = 'flex';
    }
}

// Manejo de tabs de modo
let modoActual = 'general';

document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.mode-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Quitar active de todos
            tabs.forEach(t => t.classList.remove('active'));
            // Agregar active al clickeado
            this.classList.add('active');
            // Guardar modo actual
            modoActual = this.dataset.mode;
            
            // Feedback visual
            const input = document.getElementById('mensajeAsistente');
            input.placeholder = getPlaceholderForMode(modoActual);
        });
    });
});

function getPlaceholderForMode(mode) {
    const placeholders = {
        'general': 'Pregúntame cualquier cosa sobre prompts...',
        'generar': 'Describe el prompt que necesitas generar...',
        'optimizar': 'Pega aquí el prompt que quieres optimizar...',
        'ayuda': '¿Qué necesitas aprender sobre prompts?...'
    };
    return placeholders[mode] || 'Escribe tu mensaje...';
}

// Contador de caracteres y auto-resize
document.getElementById('mensajeAsistente').addEventListener('input', function() {
    const length = this.value.length;
    const counter = document.getElementById('charCounter');
    const sendBtn = document.getElementById('enviarBtn');
    
    counter.textContent = `${length}/1000 caracteres`;
    sendBtn.disabled = length === 0;
    
    // Auto resize
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Enviar con Enter (Shift+Enter para nueva línea)
document.getElementById('mensajeAsistente').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        if (!document.getElementById('enviarBtn').disabled) {
            enviarMensaje();
        }
    }
});

// Enviar mensaje
async function enviarMensaje() {
    const input = document.getElementById('mensajeAsistente');
    const mensaje = input.value.trim();
    const contexto = modoActual; // Usar el modo actual de los tabs
    
    if (!mensaje) return;
    
    // Agregar mensaje del usuario
    agregarMensaje(mensaje, 'user');
    
    // Limpiar input
    input.value = '';
    input.style.height = 'auto';
    document.getElementById('charCounter').textContent = '0/1000 caracteres';
    document.getElementById('enviarBtn').disabled = true;
    
    // Mostrar typing indicator
    mostrarTyping();
    
    try {
        const response = await fetch('{{ route('asistente.chat') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ mensaje, contexto })
        });
        
        const data = await response.json();
        
        // Remover typing indicator
        removerTyping();
        
        if (data.success) {
            agregarMensaje(data.respuesta, 'asistente');
            
            // Mostrar badge si es modo demo o fallback
            if (data.demo) {
                console.log('💡 Modo DEMO activo. Configura GEMINI_API_KEY en .env para usar IA real.');
            }
            if (data.fallback) {
                console.log('⚠️ Fallback a modo DEMO. Verifica tu GEMINI_API_KEY.');
            }
        } else {
            agregarMensaje('❌ ' + (data.error || 'Error al procesar tu mensaje'), 'asistente');
        }
    } catch (error) {
        removerTyping();
        agregarMensaje('❌ Error de conexión. Por favor intenta de nuevo.', 'asistente');
        console.error('Error:', error);
    }
}

// Agregar mensaje al chat
function agregarMensaje(texto, tipo) {
    const messagesContainer = document.getElementById('chatMessages');
    const now = new Date();
    const time = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${tipo}-message`;
    
    const avatarIcon = tipo === 'user' ? 'fa-user' : 'fa-robot';
    
    messageDiv.innerHTML = `
        <div class="message-avatar">
            <i class="fas ${avatarIcon}"></i>
        </div>
        <div class="message-content">
            <div class="message-text">${texto.replace(/\n/g, '<br>')}</div>
            <div class="message-time">${time}</div>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Mostrar indicador de escritura
function mostrarTyping() {
    const messagesContainer = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.className = 'message asistente-message typing-message';
    typingDiv.id = 'typingIndicator';
    
    typingDiv.innerHTML = `
        <div class="message-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="message-content">
            <div class="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(typingDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Remover indicador
function removerTyping() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

// Limpiar chat
function limpiarChat() {
    if (confirm('¿Quieres limpiar el historial del chat?')) {
        const messagesContainer = document.getElementById('chatMessages');
        messagesContainer.innerHTML = `
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h4>Chat limpiado ✨</h4>
                <p class="welcome-subtitle">¿En qué más puedo ayudarte?</p>
            </div>
        `;
    }
}

// Enviar mensaje rápido
function enviarMensajeRapido(mensaje) {
    document.getElementById('mensajeAsistente').value = mensaje;
    document.getElementById('mensajeAsistente').dispatchEvent(new Event('input'));
    enviarMensaje();
}
</script>
