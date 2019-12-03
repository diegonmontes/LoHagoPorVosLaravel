<template>
        <div class="row">

    <div class="input-group">
            <div class="col-md-10" style="padding-right: 0px !important;">
        <input id="btn-input" type="text" name="mensaje" class="form-control input-sm" placeholder="Escriba su mensaje..." v-model="newMessage" @keyup.enter="sendMessage">
            </div>
            <div class="col-md-2" style="padding-left: 0px !important;">
        <span class="input-group-btn">
            <button class="btn btn-primary btn-block" id="btn-chat" @click="sendMessage">
                <i class="far fa-paper-plane"></i>
            </button>
        </span>
            </div>
        </div>
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
