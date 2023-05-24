<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

        //$topic->setAttribute('body', clean($topic->getAttribute('body'), 'user_topic_body'));
        //$topic->setAttribute('excerpt', make_excerpt($topic->getAttribute('body')));
    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 使用队列的异步方式
            // 推送翻译 Slug 的任务到队列
            dispatch(new TranslateSlug($topic));

            // 同步的方式会因为网络请求的不确定性而产生隐患，弃用了
            //$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}
