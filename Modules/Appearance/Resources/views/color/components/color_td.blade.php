
<style>
.base-color{
    height:20px;
    width:20px;
    display: inline-block;
    background-color: {{ $data->base_color }};
}
.text-color{
    height:20px;
    width:20px;
    display: inline-block;
    background-color: {{ $data->text_color }};
}
.scroll-color{
    height:20px;
    width:20px;
    display: inline-block;
    background-color: {{ $data->scroll_color }};
}
.success-color{
    height:20px;
    width:20px;
    display: inline-block;
    background-color: {{ $data->success_color }};
}
.warning-color{
    height:20px;
    width:20px;
    display: inline-block;
    background-color: {{ $data->warning_color }};
}
.danger-color{
    height:20px;
    width:20px;
    display: inline-block;
    background-color: {{ $data->danger_color }};
}
.color_div {
    justify-content: left;
    display: grid;
    max-width: 100%;
    max-height: 200px;
    align-items: center;
}
</style>

<div class="color_div">
    <div>Base color: &nbsp; &nbsp;<div class="base-color"></div></div>
    <div>Scroll color: &nbsp; &nbsp;<div class="scroll-color"></div></div>
    <div>Text color: &nbsp; &nbsp;<div class="text-color"></div></div>
    <div>Success color: &nbsp; &nbsp;<div class="success-color"></div></div>
    <div>Warning color: &nbsp; &nbsp;<div class="warning-color"></div></div>
    <div>Danger color: &nbsp; &nbsp;<div class="danger-color"></div></div>
</div>
