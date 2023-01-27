$(function () {
    $.ajax({
        url: 'ajax/get_team_profile.php',
        dataType: 'json',
        type: 'POST',
        success: (reslut) => {
            console.log(reslut)
            if (reslut.success) {
                group(reslut.team, reslut.data, reslut.member_id)
            }
        }
    })
})

function sendmail(email) {
    //送出邀請
    Swal.fire({
        title: '寄送中......',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: 'ajax/send_team_invitation.php',
                data: {
                    email: email
                },
                dataType: 'json',
                type: 'POST',
                success: (reslut) => {
                    // console.log(reslut)
                    if (reslut.success) {
                        Swal.fire({
                            icon: "success",
                            title: reslut.msg,
                        }).then((result) => {
                            window.location.href = "./";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: reslut.msg,
                        })
                    }
                }
            })
        }
    })
}

function real_profile(email) {
    Swal.fire({
        title: "請填寫您的基本資料",
        html: `
        <form id="real_profile">
        <div class="col-lg-12"><label class="mb-3">真實姓名：<input id="real_name" class="form-control" type="text" name="real_name" /></label></div>
        <div class="col-lg-12"><label class="mb-3">電話號碼：<input id="phone_number"  class="form-control" type="text" name="phone_number" /></label></div>
        <div class="col-lg-12"><label class="mb-3">性別：<select id="gender" class="form-select" name="gender"><option value="男">男</option><option value="女">女</option></select></label></div>
        <div class="col-lg-12"><label class="mb-3">年齡：<input id="age"  class="form-control" type="number" name="age" min="0" /></label></div>
        </from>
        `,
        allowOutsideClick: false,
        preConfirm: () => {
            $("#real_profile").validate({
                errorElement: 'div',
                rules: {
                    real_name: {
                        required: true,
                    },
                    phone_number: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    age: {
                        required: true,
                    },

                }
            });
            if (!$("#real_profile").valid()) return false
            return $("#real_profile").serialize()

        }
    }).then((res) => {
        console.log(res)
        if (res.isConfirmed) {
            $.ajax({
                url: 'ajax/set_member_realprofile.php',
                data: res.value,
                dataType: 'json',
                type: 'POST',
                success: (reslut) => {
                    console.log(reslut)
                    if (reslut.success) {
                        Swal.fire({
                            icon: "success",
                            title: reslut.msg,
                        }).then(() => {
                            sendmail(email)
                        })
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: reslut.msg,
                        }).then(() => {
                            real_profile()
                        })
                    }
                }
            })
        }
    });
}


function group(team, data, member_id) {

    if (team) {//已組隊
        $("#group").html(`
        <div class="row">
            <div class="col-sm-3">
                <h6 class="mb-0">隊伍名稱</h6>
            </div>
            <div id="team-name" class="col-sm-6 text-secondary">
                ${data.team_name}
            </div>
            <div id="team-leave" class="col-sm-3 text-secondary">
            
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <h6 class="mb-0">隊長</h6>
            </div>
            <div id="team-leader" class="col-sm-6 text-secondary">
                ${data.leader[0].member_name}
            </div>
            <div id="team-leader-control" class="col-sm-3 text-secondary">
                
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <h6 class="mb-0">隊員</h6>
            </div>
            <div id="team-members" class="col-sm-9 text-secondary">
                ${data.member.map(elements => !elements ? "" : elements.member_name).join("，")}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb-3">
                <div class="col-sm-3 h6 mb-0">測驗分數分布圖</div>
                <div class="col-sm-6" id="total-point"></div>
                
                </div>
                
            </div>
            <div class="col-sm-6 chart-container mb-3">
                <canvas width="400" height="400"  id="team-chart" ></canvas>
            </div>
            <div class="col-sm-6 chart-container mb-3">
                <canvas width="400" height="400"  id="mamber1-chart" ></canvas>
            </div>
            <div class="col-sm-6 chart-container mb-3">
                <canvas width="400" height="400"  id="mamber2-chart" ></canvas>
            </div>
            <div class="col-sm-6 chart-container mb-3">
                <canvas width="400" height="400"  id="mamber3-chart" ></canvas>
            </div>
            <div class="col-sm-6 chart-container mb-3">
                <canvas width="400" height="400"  id="mamber4-chart" ></canvas>
            </div>
            <div class="col-sm-6 chart-container mb-3">
                <canvas width="400" height="400"  id="mamber5-chart" ></canvas>
            </div>
        </div>
        `)

        //隊長權限
        if (member_id == data.leader[0].member_id) {
            if (data.member.length < 4) {
                $("#team-leader-control").append(
                    `<button id="invite" class="btn btn-primary">邀請</button>`
                )
                $("#invite").on("click", () => {
                    Swal.fire({
                        title: "請輸入邀請對象的EMAIL",
                        input: 'email',
                        inputPlaceholder: 'EMAIL'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // 20210823 填寫基本資料

                            $.ajax({
                                url: 'ajax/check_member_realprofile.php',
                                dataType: 'json',
                                type: 'POST',
                                success: (reslut) => {
                                    console.log(reslut)
                                    if (reslut.success) {
                                        if (reslut.status) {
                                            real_profile(result.value)
                                        } else {
                                            sendmail(result.value)
                                        }
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: reslut.msg,
                                        })
                                    }

                                }
                            })

                        }
                    });
                })
            }
            if (data.member.length == 0) {
                $("#team-leave").append(
                    `<button id="remove_team" class="btn btn-primary">解散隊伍</button>`
                )
                $("#remove_team").on("click", () => {
                    Swal.fire({
                        icon: "warning",
                        title: "確定要解散隊伍?",
                        showCancelButton: true,
                        cancelButtonText: "否",
                        confirmButtonText: "是",
                    }).then((result) => {
                        console.log(member_id)
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'ajax/remove_team.php',
                                data: {
                                    team_id: data.team_id,
                                },
                                dataType: 'json',
                                type: 'POST',
                                success: (reslut) => {
                                    console.log(result)
                                    if (reslut.success) {
                                        Swal.fire({
                                            icon: "success",
                                            title: reslut.msg,
                                        }).then((result) => {
                                            window.location.href = "./";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: reslut.msg,
                                        }).then((result) => {
                                            window.location.href = "./";
                                        });
                                    }
                                }
                            })
                        }
                    });
                })
            }
            else {
                //踢隊員
                $("#team-leave").append(
                    `<button id="kick" class="btn btn-primary">剔除隊員</button>`
                )
                var rObj = {};
                data.member.forEach(function (v, k) {
                    rObj[v.member_id] = v.member_name;
                })
                $("#kick").on("click", () => {
                    Swal.fire({
                        title: "選擇剔除對象",
                        input: 'select',
                        inputOptions: rObj,
                        inputPlaceholder: '選擇隊員',
                        showCancelButton: true,
                        cancelButtonText: "取消",
                        confirmButtonText: "確定",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let member_id = result.value
                            Swal.fire({
                                icon: "warning",
                                title: "確定要剔除?",
                                showCancelButton: true,
                                cancelButtonText: "否",
                                confirmButtonText: "是",
                            }).then((result) => {
                                console.log(member_id)
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: 'ajax/kick_teammate.php',
                                        data: {
                                            team_id: data.team_id,
                                            member_id: member_id
                                        },
                                        dataType: 'json',
                                        type: 'POST',
                                        success: (reslut) => {
                                            console.log(result)
                                            if (reslut.success) {
                                                Swal.fire({
                                                    icon: "success",
                                                    title: reslut.msg,
                                                }).then((result) => {
                                                    window.location.href = "./";
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: "error",
                                                    title: reslut.msg,
                                                }).then((result) => {
                                                    window.location.href = "./";
                                                });
                                            }
                                        }
                                    })
                                }
                            });
                        }
                    });
                })
            }

        } else {
            //隊員權限
            $("#team-leave").append(
                `<button id="leave" class="btn btn-primary">離開隊伍</button>`
            )
            $("#leave").on("click", () => {
                Swal.fire({
                    icon: "warning",
                    title: "確定要離開?",
                    showCancelButton: true,
                    cancelButtonText: "否",
                    confirmButtonText: "是",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'ajax/leave_team.php',
                            data: {
                                team_id: data.team_id,
                                leader_id: data.leader[0].member_id
                            },
                            dataType: 'json',
                            type: 'POST',
                            success: (reslut) => {
                                console.log(result)
                                if (reslut.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: reslut.msg,
                                    }).then((result) => {
                                        window.location.href = "./";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: reslut.msg,
                                    })
                                }
                            }
                        })
                    }
                });
            })
        }

        // //圖表
        var radar_scale_font = window.innerWidth >= 768 ? 20 : 10

        let options = {
            responsive: true,
            elements: {
                line: {
                    tension: 0,
                    borderWidth: 1
                }
            },
            legend: {
                display: false,
                labels: {
                    fontSize: 25,
                }
            },
            scale: {
                ticks: {
                    min: -10,
                    max: 100,
                    beginAtZero: false,
                },
                pointLabels: {
                    fontSize: radar_scale_font
                }
            },
            title: {
                display: true,
                text: "asd"
            }

        }

        let categor = [
            'OrinArch',
            'VAR_BOX',
            'uGym_3D_Rowing',
            'SmartBoard',
            'Stampede'
        ];

        let charts = {

            leader: {
                title: data.leader[0].member_name,
                elId: 'mamber1-chart',
                point: [null, null, null, null, null]
            },
            member0: {
                title: customComparison(data.member[0]),
                elId: 'mamber2-chart',
                point: [null, null, null, null, null]
            },
            member1: {
                title: customComparison(data.member[1]),
                elId: 'mamber3-chart',
                point: [null, null, null, null, null]
            },
            member2: {
                title: customComparison(data.member[2]),
                elId: 'mamber4-chart',
                point: [null, null, null, null, null]
            },
            member3: {
                title: customComparison(data.member[4]),
                elId: 'mamber5-chart',
                point: [null, null, null, null, null]
            },
            team: {
                title: "隊伍分數",
                elId: 'team-chart',
                point: [null, null, null, null, null]
            }
        }

        let out = []
        for (key in categor) {
            out.push(
                pointCount(
                    data.leader[0][categor[key]],
                    categor[key],
                    {
                        top: data.point_range[categor[key] + "_top"],
                        low: data.point_range[categor[key] + "_low"]
                    })
            )
        }
        charts.leader['point'] = out

        data.member.forEach((v, k) => {
            let out = []
            for (key in categor) {
                out.push(
                    pointCount(
                        v[categor[key]],
                        categor[key],
                        {
                            top: data.point_range[categor[key] + "_top"],
                            low: data.point_range[categor[key] + "_low"]
                        })
                )
            }
            charts['member' + k].point = out
        })

        //隊伍成績比較
        let teamout = []
        for (let i = 0; i < 5; i++) {
            teamout.push([charts.leader.point[i], charts.member0.point[i], charts.member1.point[i], charts.member2.point[i], charts.member3.point[i]].reduce((a, b) => Math.max(a, b)))
            // teamout.push(pointAvg([charts.leader.point[i], charts.member0.point[i], charts.member1.point[i], charts.member2.point[i], charts.member3.point[i]]))
        }
        charts.team.point = teamout
        console.log(charts)
        $("#total-point").append(`總分：${Number.parseFloat(teamout.reduce((a, b) => Number.parseFloat(a) + Number.parseFloat(b))).toFixed(2)}`)

        for (key in charts) {
            let ctxt = document.getElementById(charts[key].elId).getContext('2d');
            options.title.text = charts[key].title
            let radar_data = {
                labels: [
                    'OrinArch',
                    'VAR BOX',
                    'uGym 3D Rowing',
                    'SmartBoard',
                    'Stampede'
                ],
                datasets: [{
                    label: '測驗分數分布圖',
                    data: charts[key].point,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            };
            new Chart(ctxt, {
                type: 'radar',
                data: radar_data,
                options: options
            });
        }

        let rankobj = ""
        data.team_rank.forEach((v, k) => {
            if (k > 19) return
            if (v.total_point > 0) {
                rankobj += `<tr><td>${v.rank}</td><td>${v.team_name}</td><td>${Number.parseFloat(v.total_point).toFixed(2)}</td></tr>`
            }
        })

        // for (var i = 0; i < 20; i++) {
        //     rankobj += rankobj
        // }

        // $("#v-pills-tab").append(
        //     `<a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"></a>`
        // )
        // $("#v-pills-tabContent").append(
        //     ``
        // )
        $("#group").append(`
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb-3">
                <div class="col-sm-3 h6 mb-0">排名</div>  
            </div>
            <table  class="table">
                <thead><tr><th>排名</th><th>隊伍名稱</th><th>總分</th></tr></thead>
                <tbody>`+ rankobj + `</tbody></table>
        </div>
        `)
        // $("#Leaderboard").on("click", () => {
        //     Swal.fire({
        //         title: "排行榜",
        //         html: `<table  class="table">
        //         <thead><tr><th>排名</th><th>隊伍名稱</th><th>總分</th></tr></thead>
        //         <tbody>`+ rankobj + `</tbody></table>`,
        //     })
        // })

    } else {//未組隊
        $("#group").html(`
                <form id="team_form">
                    <div class="h4">創建隊伍</div>
                    隊伍名稱<input id="team_name" class="form-control mb-3" name="team_name"/>
                    <button id="creat-group" class="btn btn-primary">創建</button>
                </form>
        `)
        $("#team_form").validate({
            errorElement: 'div',
            rules: {
                team_name: {
                    required: true,
                },
            }
        });

        $("#creat-group").on("click", () => {
            if (!$("#team_form").valid()) return;
            event.preventDefault();
            Swal.fire({
                icon: "info",
                title: `是否創建 ${$("#team_name").val()} 隊?`,
                showCancelButton: true,
                cancelButtonText: "否",
                confirmButtonText: "是",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'ajax/create_team.php',
                        data: {
                            team_name: $("#team_name").val()
                        },
                        dataType: 'json',
                        type: 'POST',
                        success: (reslut) => {
                            if (reslut.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: reslut.msg,
                                }).then((result) => {
                                    window.location.href = "./";
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: reslut.msg,
                                })
                            }
                        }
                    })
                }
            })
        })
    }
}

function pointAvg(pointArr) {
    return Number.parseFloat(
        (pointArr.reduce(function (a, b) {
            if (a == null) { a = 0 }
            if (b == null) { b = 0 }
            //console.log(Number.parseFloat(a) + Number.parseFloat(b))
            return Number.parseFloat(a) + Number.parseFloat(b)
        })) / 5
    ).toFixed(2)
}

function pointCount(point, key, range) {
    if (point == 0 || point == null) {
        return null
    } else {
        if (key == 'uGym_3D_Rowing') {
            return Number.parseFloat((1 - (point - range.low) / (range.top - range.low)) * 100).toFixed(2)
        } else {
            return Number.parseFloat(((point - range.low) / (range.top - range.low)) * 100).toFixed(2)
        }
    }
}

function customComparison(arr) {
    return !arr ? null : arr.member_name
}