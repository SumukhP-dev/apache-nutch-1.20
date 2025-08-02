export JAVA_HOME="/usr/lib/jvm/java-21-openjdk-amd64"

cd crawler/solr-8.11.4/bin
bash solr start

bash solr delete -c nutch
bash solr create -c nutch

cd ..
cd ..

cd urls

>seed.txt
echo $1 >> seed.txt

cd ..

bash bin/nutch inject crawl/crawldb urls
bash bin/nutch generate crawl/crawldb crawl/segments -topN $2
s2=$(ls -d crawl/segments/2* | tail -1)
bash bin/nutch fetch $s2
bash bin/nutch parse $s2
bash bin/nutch updatedb crawl/crawldb $s2
bash bin/nutch invertlinks crawl/linkdb -dir crawl/segments
bash bin/nutch index crawl/crawldb/ -linkdb crawl/linkdb/ -dir crawl/segments/ -filter -normalize -deleteGone
