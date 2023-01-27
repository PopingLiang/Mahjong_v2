<?php require APPROOT . 'views/inc/header.php'; ?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">歷史紀錄</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="record" class="display">
                    <thead>
                        <tr>
                            <th style="width: 100%;">將</th>
                            <th style="width: 100%;">風</th>
                            <th style="width: 100%;">東</th>
                            <th style="width: 100%;">南</th>
                            <th style="width: 100%;">西</th>
                            <th style="width: 100%;">北</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <table id="record-tal" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>總分</th>
                            <th>東</th>
                            <th>南</th>
                            <th>西</th>
                            <th>北</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <input class="form-control " type="text">
    </div>

</div>

<form id="set" action="POST">
    <table class="table table-bordered text-center text-info">
        <tbody>
            <tr>
                <th class="h2">底</th>
                <td><input class="form-control" type="number" name="base_point" id="base_point"></td>
                <th class="h2">台</th>
                <td><input class="form-control " type="number" name="bonus_point" id="bonus_point"></td>
            </tr>


        </tbody>
    </table>
    <div class="row justify-content-center mb-1">
        <div class="col-auto"><button id="setpoint" type="button" class="btn btn-primary">設定</button></div>
    </div>
</form>
<table id="panel" class="table table-bordered text-center text-info d-none">
    <thead>
        <tr>
            <th><button class="btn btn-warning" type="button" onclick="stayStage()">留局</button></th>
            <th><button class="btn btn-danger" type="button" onclick="back()">返回</button></th>
            <th><button id="next" class="btn btn-success" type="button" onclick="nextGame()">新局</button></th>
            <th><button class="btn btn-primary" type="button" onclick="record()" data-bs-toggle="modal" data-bs-target="#exampleModal">當局紀錄</button></th>
            <th><button class="btn btn-primary" type="button" onclick="hisrecord()" data-bs-toggle="modal" data-bs-target="#exampleModal">歷史紀錄</button></th>
        </tr>
    </thead>
</table>
<form id="show" class="d-none" action="POST">
    <table class="table table-bordered align-middle text-center text-info">
        <thead>
            <tr>
                <th colspan="2">數據統計</th>
                <th id="showpoint"></th>
            </tr>
            <tr>
                <th colspan="5" class="h2">
                    <div class="row">
                        <div class="col text-nowrap">
                            <div class="row justify-content-center">
                                <div class="col-auto" id="wind" data-id="E" data-k="0">東</div>風
                                <div class="col-auto" id="pos" data-id="E" data-k="0">東</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">連：</span>
                                <input class="form-control" id="count" type="number" value="0" readonly>
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th></th>
                <td><input class="form-control" type="text" name="p1" id="p1"></td>
                <td><input class="form-control" type="text" name="p2" id="p2"></td>
                <td><input class="form-control" type="text" name="p3" id="p3"></td>
                <td><input class="form-control" type="text" name="p4" id="p4"></td>
            </tr>
            <tr>
                <th></th>
                <th id="E">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="caculate('E')">東</button>
                    </div>
                </th>
                <th id="S">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="caculate('S')">南</button>
                    </div>
                </th>
                <th id="W">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="caculate('W')">西</button>
                    </div>
                </th>
                <th id="N">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="caculate('N')">北</button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr id="default_point">
                <td id="index">0</td>
                <td id="E">0</td>
                <td id="S">0</td>
                <td id="W">0</td>
                <td id="N">0</td>
            </tr>
        </tbody>
    </table>

</form>


<?php require APPROOT . 'views/inc/footer.php'; ?>

<script>
    class npro {
        npro = {
            pos: ["E", "S", "W", "N"],
            posn: {
                "E": "東",
                "S": "南",
                "W": "西",
                "N": "北"
            },
            scor: {
                "E": 0,
                "S": 0,
                "W": 0,
                "N": 0
            },
            player: {
                "E": {
                    win: 0,
                    winself: 0,
                    gun: 0
                },
                "S": {
                    win: 0,
                    winself: 0,
                    gun: 0
                },
                "W": {
                    win: 0,
                    winself: 0,
                    gun: 0
                },
                "N": {
                    win: 0,
                    winself: 0,
                    gun: 0
                }
            },
            playerN: {
                "E": 0,
                "S": 0,
                "W": 0,
                "N": 0
            },
            hisscor: new Array()
        }
        constructor() {
            return this.npro
        }
    }
    let porhis = new Array()
    let pro = new npro()
    let index = 1

    function nextGame() {
        pro.playerN.E = $("#p1").val()
        pro.playerN.S = $("#p2").val()
        pro.playerN.W = $("#p3").val()
        pro.playerN.N = $("#p4").val()
        porhis.push(pro)
        pro = new npro()

        // console.log(porhis)
    }

    function stayStage() {
        let banker = $("#pos").data("id")
        let wind = $("#wind").data("id")
        pro.hisscor.push({
            bankercout: $("#count").val(),
            wind: wind + banker,
            "E": 0,
            "S": 0,
            "W": 0,
            "N": 0
        })
        $("#count").val(parseInt($("#count").val()) + 1)
        $("#show tbody").prepend(`<tr><td>${index++}</td><td>${pro.scor.E}</td><td>${pro.scor.S}</td><td>${pro.scor.W}</td><td>${pro.scor.N}</td></tr>`)
        // console.log(pro)
    }

    function back() {
        if (pro.hisscor.length > 0) {
            let lastdata = pro.hisscor[pro.hisscor.length - 1]
            $("#count").val(lastdata.bankercout)
            var pos = lastdata.wind[1] == "E" ? 0 : lastdata.wind[1] == "S" ? 1 : lastdata.wind[1] == "W" ? 2 : lastdata.wind[1] == "N" ? 3 : ""
            var wind = lastdata.wind[0] == "E" ? 0 : lastdata.wind[0] == "S" ? 1 : lastdata.wind[0] == "W" ? 2 : lastdata.wind[0] == "N" ? 3 : ""
            $("#pos").html(pro.posn[pro.pos[pos]])
            $("#pos").data("k", pos)
            $("#pos").data("id", pro.pos[pos])
            $("#wind").html(pro.posn[pro.pos[wind]])
            $("#wind").data("k", wind)
            $("#wind").data("id", pro.pos[wind])
            pro.hisscor.pop()
            let temp = {
                "E": 0,
                "S": 0,
                "W": 0,
                "N": 0
            }
            for (var k in pro.hisscor) {
                temp.E += pro.hisscor[k].E
                temp.S += pro.hisscor[k].S
                temp.W += pro.hisscor[k].W
                temp.N += pro.hisscor[k].N
            }
            index--
            pro.scor = temp
            $("#show tbody tr")[0].remove()
            console.log(pro)
        }

    }


    $('#record').DataTable({
        data: pro.hisscor,
        columns: [{
                data: "bankercout",
                render: function(data, type, row, meta) {
                    return porhis.length + 1;
                },
            },
            {
                data: 'wind'
            },
            {
                data: 'E'
            },
            {
                data: 'S'
            },
            {
                data: 'W'
            },
            {
                data: 'N'
            }
        ],
        // autoWidth: true,
        paging: false,
        searching: false,
        info: false,
        // ordering: false,
        scrollY: 250,
    });

    function record() {
        console.log(pro.hisscor)
        $("#record-tal tbody").html(`<tr><td>總分</td><td>${pro.scor.E}</td><td>${pro.scor.S}</td><td>${pro.scor.W}</td><td>${pro.scor.N}</td></tr>`)
        $('#record').DataTable().destroy()
        $('#record').DataTable({
            data: pro.hisscor,
            columns: [{
                    data: "bankercout",
                    render: function(data, type, row, meta) {
                        return porhis.length + 1;
                    },
                },
                {
                    data: 'wind'
                },
                {
                    data: 'E'
                },
                {
                    data: 'S'
                },
                {
                    data: 'W'
                },
                {
                    data: 'N'
                }
            ],
            // autoWidth: true,
            paging: false,
            searching: false,
            info: false,
            // ordering: false,
            scrollY: 250,
        });
    }

    function hisrecord() {
        $('#record').DataTable().destroy()
        var temp = new Array()
        $("#record-tal tbody").html("")
        for (var k in porhis) {
            for (var hisk in porhis[k].hisscor) {
                porhis[k].hisscor[hisk]["bankercout"] = k
                temp.push(porhis[k].hisscor[hisk])
            }
            $("#record-tal tbody").append(`
            <tr><td>${parseInt(k)+1}將</td>
            <td>${porhis[k].playerN.E}：${porhis[k].scor.E}</td>
            <td>${porhis[k].playerN.S}：${porhis[k].scor.S}</td>
            <td>${porhis[k].playerN.W}：${porhis[k].scor.W}</td>
            <td>${porhis[k].playerN.N}：${porhis[k].scor.N}</td>
            </tr>
            `)
        }
        console.log(temp)
        $('#record').DataTable({
            data: temp,
            columns: [{
                    data: "bankercout",
                    render: function(data, type, row, meta) {
                        if (type === "display") {
                            return parseInt(data) + 1
                        }
                    },
                },
                {
                    data: 'wind'
                },
                {
                    data: 'E'
                },
                {
                    data: 'S'
                },
                {
                    data: 'W'
                },
                {
                    data: 'N'
                }
            ],
            autoWidth: true,
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            scrollY: 250,
        });

    }

    function caculate(bywho) {
        var opt = bywho == "E" ? "" : `<input type="radio" class="btn-check" id="BE" value="E" name="who">
                                        <label class="btn btn-outline-primary" for="BE">東</label>`
        opt += bywho == "S" ? "" : `<input type="radio" class="btn-check" id="BS" value="S" name="who">
                                        <label class="btn btn-outline-primary" for="BS">南</label>`
        opt += bywho == "W" ? "" : `<input type="radio" class="btn-check" id="BW" value="W" name="who">
                                        <label class="btn btn-outline-primary" for="BW">西</label>`
        opt += bywho == "N" ? "" : `<input type="radio" class="btn-check" id="BN" value="N" name="who">
                                        <label class="btn btn-outline-primary" for="BN">北</label>`
        let bp = parseInt($("#base_point").val())
        let bop = parseInt($("#bonus_point").val())
        let banker = $("#pos").data("id")
        let wind = $("#wind").data("id")
        let bcount = 1 + parseInt($("#count").val()) * 2
        let temp = {
            bankercout: $("#count").val(),
            wind: wind + banker,
            "E": 0,
            "S": 0,
            "W": 0,
            "N": 0
        }
        let fuc = () => {
            var selfscr = bywho == banker ? bcount * bop : 0
            var whoscr = $("input[name='who']:checked").val() == "self" ? bop : $("input[name='who']:checked").val() == banker ? bcount * bop : 0
            $("#talscr").html(bp + selfscr + whoscr + (bop * $("#scoring").val()))
            var talpoint = parseInt($("#scoring").val()) +
                parseInt((bywho == banker ? bcount : 0)) +
                parseInt(($("input[name='who']:checked").val() == "self" ? 1 : $("input[name='who']:checked").val() == banker ? bcount : 0))
            $("#talscoring").html(talpoint)
            $("#bankscr").html($("input[name='who']:checked").val() == banker || bywho == banker ? bcount * 20 : 0)
            $("#selfscr").html($("input[name='who']:checked").val() == "self" ? 20 : 0)
        }
        Swal.fire({
            title: "積分計算",
            html: `
            <input type="radio" class="btn-check" id="modn" value="n" name="mod" checked>
            <label class="btn btn-outline-primary" for="modn">正常</label>  
            <input type="radio" class="btn-check" id="modb" value="bomb" name="mod" >
            <label class="btn btn-outline-primary" for="modb">詐胡</label>
            <br>
            放槍者：<br>
            <input type="radio" class="btn-check" id="BSE" value="self" name="who" checked>
            <label class="btn btn-outline-primary" for="BSE">自摸</label>
            ${opt}
            <br>
            台數(牌型台，不用算莊家台)：<br><input type="number" name="scoring" id="scoring" value="0" min="0"><br>
            <div>莊家台：<span id="bankscr">${bywho == banker?bcount*bop:0}</span></div>
            <div>自摸：<span id="selfscr">${bop}</span></div>
            <div>分數：<span id="talscr"></span></div>
            <div>台數：<span id="talscoring"></span></div>
           `,
            didOpen: () => {
                fuc()
                $("input[name='who']").on("change", fuc)
                $("#scoring").on("input", fuc)
            },
            preConfirm: () => {
                return {
                    mod: $("input[name='mod']:checked").val(),
                    who: $("input[name='who']:checked").val(),
                    score: bp + (bop * $("#scoring").val())
                }
            }
        }).then((data) => {
            if (data.isConfirmed) {
                let fianlscore
                if (bywho == banker) {
                    fianlscore = (data.value.score + (bop * bcount))
                    if (data.value.who == "self") {
                        fianlscore += bop
                        for (let k in pro.scor) {
                            if (k == bywho) {
                                pro.scor[k] += (data.value.mod == "n" ? +fianlscore * 3 : -fianlscore * 3)
                                temp[k] = (data.value.mod == "n" ? +fianlscore * 3 : -fianlscore * 3)
                                pro.player[k].winself++

                            } else {
                                pro.scor[k] -= (data.value.mod == "n" ? +fianlscore : -fianlscore)
                                temp[k] = -(data.value.mod == "n" ? +fianlscore : -fianlscore)
                            }
                        }
                    } else {
                        pro.scor[bywho] += (data.value.mod == "n" ? +fianlscore : -fianlscore)
                        pro.scor[data.value.who] -= (data.value.mod == "n" ? +fianlscore : -fianlscore)
                        temp[bywho] = (data.value.mod == "n" ? +fianlscore : -fianlscore)
                        temp[data.value.who] = -(data.value.mod == "n" ? +fianlscore : -fianlscore)
                        //帶改
                        pro.player[bywho].win++
                        pro.player[data.value.who].gun++
                    }

                    if (data.value.mod == "n") {
                        $("#count").val(parseInt($("#count").val()) + 1)
                    } else {
                        countWind()
                    }

                } else {
                    fianlscore = data.value.score
                    if (data.value.who == "self") {
                        fianlscore += bop
                        for (let k in pro.scor) {
                            if (k == bywho) {
                                pro.scor[k] += (data.value.mod == "n" ? +(fianlscore * 3) + (bop * bcount) : -((fianlscore * 3) + (bop * bcount)))
                                temp[k] = (data.value.mod == "n" ? +(fianlscore * 3) + (bop * bcount) : -((fianlscore * 3) + (bop * bcount)))
                                pro.player[k].winself++
                            } else {
                                if (k == banker) {
                                    pro.scor[k] -= (data.value.mod == "n" ? +(fianlscore + (bop * bcount)) : -(fianlscore + (bop * bcount)))
                                    temp[k] = -(data.value.mod == "n" ? +(fianlscore + (bop * bcount)) : -(fianlscore + (bop * bcount)))
                                } else {
                                    pro.scor[k] -= (data.value.mod == "n" ? +fianlscore : -fianlscore)
                                    temp[k] = -(data.value.mod == "n" ? +fianlscore : -fianlscore)
                                }
                            }
                        }
                    } else {
                        fianlscore += data.value.who == banker ? +(bop * bcount) : +0
                        pro.scor[bywho] += (data.value.mod == "n" ? +fianlscore : -fianlscore)
                        pro.scor[data.value.who] -= (data.value.mod == "n" ? +fianlscore : -fianlscore)
                        temp[bywho] = (data.value.mod == "n" ? +fianlscore : -fianlscore)
                        temp[data.value.who] = -(data.value.mod == "n" ? +fianlscore : -fianlscore)
                        //帶改
                        pro.player[bywho].win++
                        pro.player[data.value.who].gun++
                    }
                    if (data.value.mod == "n") {
                        countWind()
                    } else {
                        $("#count").val(parseInt($("#count").val()) + 1)
                    }
                }
                pro.hisscor.push(temp)
                $("#show tbody").prepend(`<tr><td>${index++}</td><td>${pro.scor.E}</td><td>${pro.scor.S}</td><td>${pro.scor.W}</td><td>${pro.scor.N}</td></tr>`)
                // console.log(pro)
            }
        })

        function countWind() {
            let newbanker = (parseInt($("#pos").data("k")) + 1) % 4
            let newround = newbanker == 0 ? (parseInt($("#wind").data("k")) + 1) % 4 : parseInt($("#wind").data("k"))
            $("#pos").html(pro.posn[pro.pos[newbanker]])
            $("#pos").data("k", newbanker)
            $("#pos").data("id", pro.pos[newbanker])
            $("#wind").html(pro.posn[pro.pos[newround]])
            $("#wind").data("k", newround)
            $("#wind").data("id", pro.pos[newround])
            $("#count").val(0)
        }
    }

    $("#setpoint").on("click", () => {
        $("#set input").prop("readonly", true)
        $(`#show`).toggleClass("d-none")
        $(`#panel`).toggleClass("d-none")
        $(`#set`).toggleClass("d-none")

        $("#showpoint").html(`底${parseInt($("#base_point").val())} 台${parseInt($("#bonus_point").val())}`)
    })
</script>