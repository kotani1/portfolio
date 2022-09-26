/*
処理の流れ
クリックしたカードをfirstCard,secondCardに保存する

*/

function shuffle(){
  let number = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13'];
  let hokan;
 for (let i = 0; i < 6; i++) {
  for(let j=0; j<13; j++){
  let a = Math.floor(Math.random() * 13);
    hokan = number[j];
    number[j] = number[a];
    number[a] = hokan;
  }
  }
  return number;
}

function back_card(card){
  document.getElementById(card.id).setAttribute("src", "./images/trump/back01.png");
}

function face_up(element){
  if (element.id[0] == 'c') {
    element.setAttribute("src", "./images/trump/clover/" + element.id[1] + element.id[2] + ".png");
  } else {
    element.setAttribute("src", "./images/trump/spade/" + element.id[1] + element.id[2] + ".png");
  }
}

function check_pair(){
  if (firstCard.number != secondCard.number) { //違ったとき
    if (document.getElementById(firstCard.id) == null) {
      back_card(secondCard);
    } else {
      back_card(firstCard);
      back_card(secondCard);
    }
    firstCard = null;
    secondCard = null;
  }
  else {
    //同じカードを二回クリックしたときの判定
    if (firstCard.id[0] == secondCard.id[0]) {
      firstCard = null;
    } else { //同じとき
      img = document.createElement('img');
      let line3 = document.getElementById('line3');
      let element3 = img.cloneNode();
      let id = firstCard.id;
      element3.setAttribute("src", "./images/trump/clover/" + id[1] + id[2] + ".png");
      element3.setAttribute("class", "card");
      line3.append(element3);
      document.getElementById(firstCard.id).remove();
      document.getElementById(secondCard.id).remove();
      firstCard = null;
      secondCard = null;
      getCard++;
    }
  }
}

function set_card(){
  //kinds = 0だったらクローバー １だったらスペード
  if (kinds == 0) {
    element.setAttribute("src", "./images/trump/back01.png");
    element.setAttribute("id", "c" + numbers1[index] + "");
    kinds++;
  } else {
    element.setAttribute("src", "./images/trump/back01.png");
    element.setAttribute("id", "s" + numbers2[index] + "");
    index++;
    kinds = 0;
  }
  element.setAttribute("height", "120");
  element.setAttribute("width", "80");
}

let firstCard;
let secondCard;
let line = document.getElementById('line1');
let img = document.createElement('img');
let div= document.createElement('div');
div.setAttribute("class", "card");
//divの子要素がimg
let numbers1 = shuffle();
let numbers2 = shuffle();
let check = 0;
let kinds = 0;
let index =0;
let getCard = 0;

for (let i = 0; i < 26; i++) {
  div = div.cloneNode();
  line.append(div);
  element = img.cloneNode();
  set_card();
  //イベント付与
  element.addEventListener('click', function (event) {
    if (secondCard != null) {
      //二枚の組み合わせが正しいか判定
      check_pair();
    }

    // event.target = クリックして取得した要素
    let element = event.target;
      //<img>タグを取得 ex:id=c01
    face_up(element)

    if (firstCard == null) {
      firstCard = {
        id: element.id,
        number: element.id[1] + element.id[2],
      };
    } else {
      if (getCard == 12) {
        if (element.id[0] == 'c') {
          element.setAttribute("src", "./images/trump/clover/" + element.id[1] + element.id[2] + ".png");
        } else {
          element.setAttribute("src", "./images/trump/spade/" + element.id[1] + element.id[2] + ".png");
        }
        alert('ゲームクリア');
        location.reload();
      }
      secondCard = {
        id: element.id,
        number: element.id[1] + element.id[2],
      };
    }
  });
  div.append(element);
  check++;
  if(check==13){
    //改行
    line = document.getElementById('line2');
  }
};
