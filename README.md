# jobs
Simple web scraper. Designated to test person ability to work @ Reiz Tech :)

## Setup

Easiest way to launch this application is by using provided docker-compose configuration.

Steps to perform on your machine:

1. Clone repository
2. Stop services binding to port 80 (Apache, Nginx) if running
3. Stop Redis if running
4. cd to cloned folder
5. perform composer install by using command: 
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
6. rename or copy `.env.example` file to `.env`
5. execute command `./vendor/bin/sail up -d` to start docker containers
6. execute command `./vendor/bin/sail artisan queue:work` to enable queue's processing

## Usage

- [Create Job](#create-job)
- [View Job](#view-job)
- [Delete Job](#delete-job)
### Create Job

<a name="create-job"></a>

`POST` http://localhost/api/jobs

#### Example
```
curl --request POST \
  --url http://localhost/api/jobs \
  --header 'Content-Type: application/json' \
  --data '{
	"urls": [
		"https://quotes.toscrape.com/page/",
		"https://quotes.toscrape.com/page/2/",
		"https://quotes.toscrape.com/page/3/",
		"https://quotes.toscrape.com/page/4/"
	],
	"selectors": ".quote > span.text"
}'
```

#### Response 200

```json
{
  "data": {
    "id": "47dda34f-d74d-44d8-bbd0-17d3e83bca7a",
    "status": "new",
    "urls": [
      "https:\/\/quotes.toscrape.com\/page\/",
      "https:\/\/quotes.toscrape.com\/page\/2\/",
      "https:\/\/quotes.toscrape.com\/page\/3\/",
      "https:\/\/quotes.toscrape.com\/page\/4\/"
    ],
    "selectors": ".quote > span.text",
    "content": []
  }
}
```

### View Job
<a name="view-job"></a>

`GET` http://localhost/api/jobs/{JobId}

#### Example
```
curl --request GET \
  --url http://localhost/api/jobs/47dda34f-d74d-44d8-bbd0-17d3e83bca7a
```

#### Response 200

```json
{
  "data": {
    "id": "47dda34f-d74d-44d8-bbd0-17d3e83bca7a",
    "status": "completed",
    "urls": [
      "https:\/\/quotes.toscrape.com\/page\/",
      "https:\/\/quotes.toscrape.com\/page\/2\/",
      "https:\/\/quotes.toscrape.com\/page\/3\/",
      "https:\/\/quotes.toscrape.com\/page\/4\/"
    ],
    "selectors": ".quote > span.text",
    "content": [
      "“This life is what you make it. No matter what, you're going to mess up sometimes, it's a universal truth. But the good part is you get to decide how you're going to mess it up. Girls will be your friends - they'll act like it anyway. But just remember, some come, some go. The ones that stay with you through everything - they're your true best friends. Don't let go of them. Also remember, sisters make the best friends in the world. As for lovers, well, they'll come and go too. And baby, I hate to say it, most of them - actually pretty much all of them are going to break your heart, but you can't give up because if you give up, you'll never find your soulmate. You'll never find that half who makes you whole and that goes for everything. Just because you fail once, doesn't mean you're gonna fail at everything. Keep trying, hold on, and always, always, always believe in yourself, because if you don't, then who will, sweetie? So keep your head high, keep your chin up, and most importantly, keep smiling, because life's a beautiful thing and there's so much to smile about.”",
      "“It takes a great deal of bravery to stand up to our enemies, but just as much to stand up to our friends.”",
      "“If you can't explain it to a six year old, you don't understand it yourself.”",
      "“You may not be her first, her last, or her only. She loved before she may love again. But if she loves you now, what else matters? She's not perfect—you aren't either, and the two of you may never be perfect together but if she can make you laugh, cause you to think twice, and admit to being human and making mistakes, hold onto her and give her the most you can. She may not be thinking about you every second of the day, but she will give you a part of her that she knows you can break—her heart. So don't hurt her, don't change her, don't analyze and don't expect more than she can give. Smile when she makes you happy, let her know when she makes you mad, and miss her when she's not there.”",
      "“I like nonsense, it wakes up the brain cells. Fantasy is a necessary ingredient in living.”",
      "“I may not have gone where I intended to go, but I think I have ended up where I needed to be.”",
      "“The opposite of love is not hate, it's indifference. The opposite of art is not ugliness, it's indifference. The opposite of faith is not heresy, it's indifference. And the opposite of life is not death, it's indifference.”",
      "“It is not a lack of love, but a lack of friendship that makes unhappy marriages.”",
      "“Good friends, good books, and a sleepy conscience: this is the ideal life.”",
      "“Life is what happens to us while we are making other plans.”",
      "“I love you without knowing how, or when, or from where. I love you simply, without problems or pride: I love you in this way because I do not know any other way of loving but this, in which there is no I or you, so intimate that your hand upon my chest is my hand, so intimate that when I fall asleep your eyes close.”",
      "“For every minute you are angry you lose sixty seconds of happiness.”",
      "“If you judge people, you have no time to love them.”",
      "“Anyone who thinks sitting in church can make you a Christian must also think that sitting in a garage can make you a car.”",
      "“Beauty is in the eye of the beholder and it may be necessary from time to time to give a stupid or misinformed beholder a black eye.”",
      "“Today you are You, that is truer than true. There is no one alive who is Youer than You.”",
      "“If you want your children to be intelligent, read them fairy tales. If you want them to be more intelligent, read them more fairy tales.”",
      "“It is impossible to live without failing at something, unless you live so cautiously that you might as well not have lived at all - in which case, you fail by default.”",
      "“Logic will get you from A to Z; imagination will get you everywhere.”",
      "“One good thing about music, when it hits you, you feel no pain.”",
      "“The more that you read, the more things you will know. The more that you learn, the more places you'll go.”",
      "“Of course it is happening inside your head, Harry, but why on earth should that mean that it is not real?”",
      "“The truth is, everyone is going to hurt you. You just got to find the ones worth suffering for.”",
      "“Not all of us can do great things. But we can do small things with great love.”",
      "“To the well-organized mind, death is but the next great adventure.”",
      "“All you need is love. But a little chocolate now and then doesn't hurt.”",
      "“We read to know we're not alone.”",
      "“Any fool can know. The point is to understand.”",
      "“I have always imagined that Paradise will be a kind of library.”",
      "“It is never too late to be what you might have been.”"
    ]
  }
}
```

### Delete Job
<a name="delete-job"></a>

`DELETE` http://localhost/api/jobs/{JobId}

#### Example
```
  curl --request DELETE \
  --url http://localhost/api/jobs/47dda34f-d74d-44d8-bbd0-17d3e83bca7a
```

#### Response 204
