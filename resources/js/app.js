
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./jquery.js');
require('./popper.js');
require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);
import chatmessages from './components/ChatMessages.vue'; 
Vue.component('chat-messages', chatmessages);
import chatform from './components/ChatForm.vue'; 
Vue.component('chat-form', chatform);


if(document.getElementById('app')){
const app = new Vue({
    
    el: '#app',
    
    data: {
        messages: []
    },

    created() {
        var idConversacionChat = location.search.split('/')[1];
        var idPersonaLogeada = document.querySelector("input[name=idPersonaLogeada]").value;

        this.fetchMessages(idConversacionChat,idPersonaLogeada);

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    persona: e.persona,
                    mensaje: e.mensaje.mensaje,
                });
                    document.getElementById('ultimoMensajeConversacion'+e.idConversacionChat).innerHTML = e.mensaje.mensaje;
                    document.getElementById('notificacionConversacion'+e.idConversacionChat).classList.add('circuloNotificacion');
                    document.getElementById('ultimoMensajeConversacion'+e.idConversacionChat).classList.add('mensajeSinLeer');
            });
    },

    methods: {
        fetchMessages(idConversacionChat,idPersonaLogeada) {
            axios.post('messages',{
                headers: {
                    "Content-type": "application/json"
                },
                idConversacionChat:idConversacionChat,
                idPersonaLogeada:idPersonaLogeada
            }).then(response => {
                this.messages = response.data;
            });
        },
        addMessage(message) {
//            var idConversacionChat = location.search.split('/')[1]; // obtenemos el id
            var idConversacionChat = document.querySelector("input[name=idConversacionChat]").value;
            
            this.messages.push(message);

            if(document.getElementById('ultimoMensajeConversacion')){
                document.getElementById('ultimoMensajeConversacion'+idConversacionChat).innerHTML = message.mensaje;
            }

            axios.post('enviarmensaje',{
                headers: {
                    "Content-type": "application/json"
                },
                idConversacionChat:idConversacionChat,
                mensaje:message
            }).then(response => {
            });
            

        }
    }
});


};