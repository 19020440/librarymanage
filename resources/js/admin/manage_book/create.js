$(function() {
    $("#form-create-book .btn-create-book").on('click', function() {
        $("#form-create-book").submit();
    });



});

      $(function() {

        let categorys = {
          'Arts & Photography': 3,
          'Biographies & Memoirs': 4,
          'Business & Money': 2,
          'Christian Books & Bibles': 7,
          'Comics & Graphic Novels': 6,
          'Computers & Technology': 2,
          'Cookbooks, Food & Wine': 0,
          'Crafts, Hobbies & Home': 0,
          'Education & Teaching': 4,
          'Engineering & Transportation': 2,
          'Health, Fitness & Dieting': 0,
          'History': 4,
          'Humor & Entertainment': 0,
          'Law': 1,
          'Literature & Fiction': 3,
          'Medical Books': 5,
          'Mystery, Thriller & Suspense': 7,
          'Parenting & Relationships': 0,
          'Politics & Social Sciences': 1,
          'Reference': 1,
          'Religion & Spirituality': 7,
          'Romance': 7,
          'Science & Math': 5,
          'Science Fiction & Fantasy': 0,
          'Self-Help': 0,
          'Sports & Outdoors': 0,
          'Teen & Young Adult':0,
          'Test Preparation': 5,
          'Travel': 0,
          "Children's Books": 8,
        };
        const intBindStringMoney = (e) => {
          let arr = [];
          while(e > 0) {
              let test = e%1000;
               arr.unshift("." + test.toString());
              e=Math.floor(e/1000);
          }
          return arr.join('').substr(1,arr.join('').length).replaceAll('.','');
        }

        let a = document.querySelector('.navbar1')
        a.children[0].onclick = (e) => {

            const b = document.querySelector('.book').getAttribute('class');
            console.log(b);
            if (b.split(' ')[2] == undefined) {
                document.querySelector('.book').setAttribute('class', `${b} activeWidth`)
            } else {
                document.querySelector('.book').setAttribute('class', 'grid book')
            }
        }



    $('#ISBN').on('click', function() {

      if($(this).parent().prev().val() !='' ) {
        if(checkISBN($(this).parent().prev().val()) == false) {
          alert("Not Found");
          return;
        } else {
          $.ajaxSetup({
            beforeSend: function(xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                  }
              },
          });
          $.ajax({
            type: 'POST',
            url: '/ajax/getdata',
            data:{
              link:  $('#ISBN').parent().prev().val(),
            },
            success: function(res) {
              let  data = JSON.parse(res);
              $('#exampleFormControlTextarea1').val(decodeHtml(decodeHtmlCharCodes(data.content).trim()));
              $('input[name="auth"]').val(decodeHtml(decodeHtmlCharCodes(data.auth).trim()));
              $('input[name="publisher"]').val(decodeHtml(data.publisher.trim().substr(0,decodeHtmlCharCodes(data.publisher).indexOf('('))));
              $('input[name="name"]').val(decodeHtml(decodeHtmlCharCodes(data.name).trim()));
              $('input[name="image1"]').next().attr('src',data.frontImage);
              $('input[name="image1"]').next().attr('class','');
              $('input[name="image1"]').val(data.frontImage);
              $('input[name="image2"]').next().attr('src',data.behindImage);
              $('input[name="image2"]').next().attr('class','');
              $('input[name="image2"]').val(data.behindImage);
              $('input[name="price"]').val(intBindStringMoney(data.price.slice(data.price.indexOf('$')+1) * 23000));
              $('input[name="year_start"]').val(decodeHtmlCharCodes(data.publisher).trim().substring(decodeHtmlCharCodes(data.publisher).trim().indexOf('(')+1, data.publisher.trim().length-1)); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
        
            }
          })
        }
        

      }
    })
    //ham chuyen nhung dau co dang '&#8217' o dinh dang nao do ve chuan
    function decodeHtmlCharCodes(str) { 
      return str.replace(/(&#(\d+);)/g, function(match, capture, charCode) {
        return String.fromCharCode(charCode);
      });
    }
    function decodeHtml(html) {
      var txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
  }
      

});
function checkISBN(isbn) {
  isbn = isbn.replaceAll('-','');
 if(isbn.length == 13) {
     let sum = 0;
     let count = 9;
     while(count > 0) {
         sum += isbn[count+2]*count;
         count--;
     }
     return (sum - ((isbn[12] == 'X' ||isbn[12] == 'x' )? 10 :isbn[12]))%11 == 0 ? true : false;

 }
 else if(isbn.length == 10) {
     let sum = 0;
     let count = 9;
     while(count > 0) {
         sum += isbn[count-1]*count;
         count--;
     }
     return (sum - ((isbn[9] == 'X' ||isbn[9] == 'x' ) ? 10 : isbn[9]))%11 == 0 ? true : false;
 } else return false;
}