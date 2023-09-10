<template>
    <div class="container">
        <q-card bordered flat class="my-card">
            <q-card-section horizontal>
                <q-card-section>
                    <q-avatar class="avatar" size="52px">
                        <img :src="img_src">
                    </q-avatar>
                </q-card-section>
                <q-card-section class="teacher-name">
                    <span class="text">
                        {{ name }}
                    </span>
                    
                </q-card-section>
                <q-card-section class="side-info">
                    <div class="info rating">
                        {{ rating }}
                        <img src="/icons/half-star.svg" alt="icon" class="icon">
                    </div>
                    <div class="info document">
                        {{ quantity }}
                        <img src="/icons/document.svg" alt="icon" class="icon">
                    </div>
                    
                </q-card-section>
            </q-card-section>
        </q-card>
    </div>
</template>

<script>
export default {
    name: 'TeacherCard',
    props: {
        name: String,
        rating: Number,
        quantity: Number,
        img_src: String,
    }
    
}

</script>

<style scoped>
.container {
    background-color: #dce9f5;
    border-radius: 8px;
    padding: 8px;
    box-shadow: 1px 1px 3px 0px #00000026;
}

.my-card {
    background-color: #fbfbfb;
    border-color: #144ec0;
    border-width: 1px;
    border-radius: 4px 100px 4px 4px;
    height: 56px;
    font-family: 'Lexend';
    
}
.avatar{
    margin-top: -15px;
}

.teacher-name{
    padding: 0px;
    color: #144ec0;
    width: 110px;
    height: 56px;
    margin-inline: 8px;
    display: flex;
    align-items: center; /* Centraliza na vertical*/
    text-align: center; /* Centraliza na horizontal*/
}
.text{
    width: 100%;
}
.side-info{
    position: relative;
    z-index: 1;
    width: 77px;
    height: 56px;
    padding-top: 0px;

}
.side-info::before {
    content: '';
    position: absolute;
    top: -2px;
    left: 0px;
    width: 100%;
    height: 98%;
    background-color: #fbfbfb;
    border-radius: 0px 0px 100px 100px;
    border-left: #144ec0 1px solid;
    z-index: -1;
    
}

.icon{
    width: 13px;
    height: 13px;
}
.info{
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 2px;
}

</style>