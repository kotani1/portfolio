import re
import time
from xmlrpc.client import boolean
import pandas as pd
from selenium import webdriver
driver = webdriver.Chrome(executable_path="C:/Users/81802/Downloads/chromedriver_win32/chromedriver.exe")
options = webdriver.ChromeOptions()
user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36'
options.add_argument('--user-agent='+user_agent)

def bunkatu(region):
  result = re.match(pattern, region)
  if result: #正規表現パターンにマッチした場合
      prefecture = result.group(1) #都道府県
      municipality = result.group(2)#市区町村
      street_number = result.group(3) #その他
  for i in range(0,len(street_number)):
    if street_number[i] in ['1','2','3','4','5','6','7','8','9','0']:
      municipality  += street_number[0:i]
      street_number = street_number[i:]
      break
  return [prefecture,municipality,street_number]

boolean1 = True
names =[]
numbers =[]
emails =[]
prefectures =[]
municipalities =[]
street_numbers =[]
localities =[]
urls =[]
ssls =[]

pattern = '''(...??[都道府県])((?:旭川|伊達|石狩|盛岡|奥州|田村|南相馬|那須塩原|東村山|武蔵村山|羽村|十日町|上越|
富山|野々市|大町|蒲郡|四日市|姫路|大和郡山|廿日市|下松|岩国|田川|大村|宮古|富良野|別府|佐伯|黒部|小諸|塩尻|玉野|
周南)市|(?:余市|高市|[^市]{2,3}?)郡(?:玉村|大町|.{1,5}?)[町村]|(?:.{1,4}市)?[^町]{1,4}?区|.{1,7}?[市町村])(.+)'''


driver.get("https://r.gnavi.co.jp/area/jp/japanese/rs/")

while boolean1:
  a_tags = driver.find_elements_by_class_name('style_titleLink__oiHVJ')
  for i in range(0,len(a_tags)):
    if len(names) == 50:
      boolean1 = False
      break
    time.sleep(5)
    #新しいタブで開く
    driver.execute_script("window.open('"+ a_tags[i].get_attribute("href")+"');")
    driver.switch_to.window(driver.window_handles[1])
    name = driver.find_element_by_id("info-name").text
    number = driver.find_element_by_class_name("number").text
    region = driver.find_element_by_class_name("region").text
    adress = bunkatu(region)

    email = driver.find_elements_by_link_text('お店に直接メールする')
    if email:
      email = email[0].get_attribute("href")[7:]
    else:
      email =''


    locality = driver.find_elements_by_class_name("locality")
    if locality:
      locality = locality[0].text
    else:
      locality = ''

    url = driver.find_elements_by_link_text('お店のホームページ')
    ssl = 'False'
    if url:
      url = url[0].get_attribute("href")
      if url[4:5] == 's':
        ssl = 'True'
    else:
      url = ''

    names += [name]
    numbers += [number]
    emails += [email]
    prefectures += [adress[0]]
    municipalities += [adress[1]]
    street_numbers += [adress[2]]
    localities += [locality]
    urls += [url]
    ssls += [ssl]

    driver.close()
    driver.switch_to.window(driver.window_handles[0])
  driver.find_element_by_class_name('style_nextIcon__M_Me_').click()
  time.sleep(1)

driver.close()
driver.quit()
data = {
    '店舗名': names,
    '電話番号': numbers,
    'メールアドレス': emails,
    '都道府県':prefectures,
    '市区町村':municipalities,
    '番地':street_numbers,
    '建物名':localities,
    'URL':urls,
    'SSL':ssls,
}
df = pd.DataFrame(data)
df.to_csv("C:/FINAL_ANSWER/Exercise_for_Pool/python/ex1_web-scraping/1-2.csv",index=False,encoding="cp932")
print('終了')
