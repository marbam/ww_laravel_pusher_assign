<template>
    <div class="players">
        <h1>Players in game</h1>
        <div>
            <ul>
                <li v-for="player in players" v-text="player"></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                players: ['None']
            }
        },
        created() {

           axios.get('/get_players/1', [])
                .then(res => {
                    if(res.data.length > 1) {
                        this.players = res.data;
                    }
                }).catch(err => {
                console.log(err)
            })

            window.Echo.channel('games').listen('PlayerCreated', e => {
                this.players.push(e.player.name);
            });
        }
    }
</script>
