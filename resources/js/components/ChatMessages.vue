<template>
    <ul class="chat">
        <li class="left clearfix" v-for="mensaje in messages">
            <div class="chat-body clearfix">
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
    </ul>
</template>

<script>
export default {
  props: ['messages']
};
</script>