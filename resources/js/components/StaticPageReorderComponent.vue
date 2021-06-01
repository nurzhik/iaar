<template>
    <div>
        <draggable class="list-group"
                   tag="ul"
                   v-model="list"
                   v-bind="dragOptions"
                   @start="drag = true"
                   @end="drag = false">
            <transition-group type="transition" :name="!drag ? 'flip-list' : null">
                <li
                        class="list-group-item"
                        v-for="(element, idx) in list"
                        :key="element.id"
                >
                    <i class="fa fa-align-justify handle"></i>

                    <span class="text">{{ element.title }} </span>
                    <input type="hidden" name="page[]" :value="element.id">
                </li>

            </transition-group>
        </draggable>
    </div>
</template>

<script>

    let id = window.list !== undefined ? window.list.length-1: 0;
    import draggable from "vuedraggable";
    export default {
        name: "handle",
        display: "Transitions",
        instruction: "Перетащите за иконку",
        order: 5,
        components: {
            draggable
        },
        data() {
            return {
                list: window.list,
                drag: false
            };
        },

        computed: {
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            },
            draggingInfo() {
                return this.dragging ? "under drag" : "";
            }
        },
        mounted:function()
        {
            $('.document_input').filemanager('image');
            console.log(window.list);
        },

        methods: {
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            kek:function(){
                $('.document_input').filemanager('image');
            },
            onChange:function(event){
                alert(1);
            },



        },



    };
</script>

<style scoped>
    .button {
        margin-top: 35px;
    }
    .flip-list-move {
        transition: transform 0.5s;
    }
    .no-move {
        transition: transform 0s;
    }
    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }
    .list-group {
        min-height: 20px;
    }
    .list-group-item {
        cursor: move;
        display:block;
        overflow:hidden;
    }
    .list-group-item i {
        cursor: pointer;
    }
    .button {
        margin-top: 35px;
    }
    .handle {
        float: left;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .close {
        float: right;
        padding-top: 8px;
        padding-bottom: 8px;
        color: red;
        position:relative;
        z-index: 333333;
        opacity:1;

    }
    input {
        display: inline-block;
        width: 50%;
    }
    .text {
        margin: 20px;
    }
</style>