<template>
    <div class="input-group">
        <input id="btn-input" type="text" name="mensaje" class="form-control input-sm" placeholder="Escriba su mensaje..." v-model="newMessage" @keyup.enter="sendMessage">
        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Enviar
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['persona'],

        data() {
            return {
                newMessage: ''
            }
        },

        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    persona: this.persona,
                    mensaje: this.newMessage
                });

                this.newMessage = ''
            }
        }    
    }
</script>
