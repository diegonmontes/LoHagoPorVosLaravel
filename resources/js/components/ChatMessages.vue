<template>
    <ul class="chat">
        <div v-if="messages.length > 0">
            <li class="left clearfix" v-for="mensaje in messages">
                <div v-if="mensaje.enviado" class="chat-body clearfix mensajeDerecha" style="padding-right: 10px !important;">
                    <div class="header">
                        <strong class="primary-font">
                            {{ mensaje.persona.nombrePersona}} {{mensaje.persona.apellidoPersona}}
                        </strong>
                    </div>
                    <p>
                        {{ mensaje.mensaje }}
                    </p>
                </div>

                <div v-else-if="mensaje.persona.idPersona == 7" class="chat-body clearfix alert alert-info" role="alert" style="margin-right: 6px !important; margin-left: 6px !important; margin-top: 6px !important;">
                    <div class="header">
                        <strong class="primary-font">
                            {{ mensaje.persona.nombrePersona}} {{mensaje.persona.apellidoPersona}}
                        </strong>
                    </div>
                    <p>
                        {{ mensaje.mensaje }}
                    </p>
                </div>

                <div v-else class="chat-body clearfix" style="padding-left: 10px !important;">
                    <div class="header">
                        <strong class="primary-font">
                            {{ mensaje.persona.nombrePersona}} {{mensaje.persona.apellidoPersona}}
                        </strong>
                    </div>
                        <p>
                            {{ mensaje.mensaje }}
                        </p>
                </div>


            </li>
        </div>
        <div v-else>
            No seleccionaste ninguna conversacion, por favor selecciona una.
        </div>
    </ul>
</template>

<script>
export default {
  props: ['messages'],
};
</script>