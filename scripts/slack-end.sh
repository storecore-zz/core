#!/bin/sh

set -ve

if [[ -n CODEBUILD_BUILD_ID ]]; then CODEBUILD_BUILD_ID=123; fi
CHANNEL="builds"
USERNAME="AWS CodeBuild"
ENDPOINT="https://hooks.slack.com/services/${SLACK_TOKEN}"
COLOR="good"

TEXT="Finished new `cat channel.txt` release build (<https://eu-west-1.console.aws.amazon.com/codebuild/home?region=${AWS_REGION}#/builds/${CODEBUILD_BUILD_ID}/view/new|`cat gitcommit.txt`>)"

JSON="{"
JSON="$JSON  \"channel\": \"#$CHANNEL\","
JSON="$JSON  \"username\": \"$USERNAME\","
JSON="$JSON"
JSON="$JSON  \"attachments\": ["
JSON="$JSON    {"
JSON="$JSON      \"fallback\": \"$TEXT\","
JSON="$JSON      \"color\": \"$COLOR\","
JSON="$JSON      \"text\": \"$TEXT\","
JSON="$JSON      \"mrkdwn_in\": [\"text\"]",
JSON="$JSON      \"unfurl_links\": true",
JSON="$JSON    }"
JSON="$JSON  ]"
JSON="$JSON}"

curl -s -o /dev/null -X POST --data-urlencode "payload=$JSON" $ENDPOINT
