<?php

function queue_getClient(): Redis {
    static $client;
    if (is_null($client)) {
        $client = new Redis();
        $client->connect(REDIS_HOST, REDIS_PORT);
        $client->select(REDIS_DB);
    }
    return $client;
}

function queue_hasJobs(string $name): bool {
    return queue_getClient()->lLen(queue_getKey($name)) > 0;
}

function queue_getNextJob(string $name): array {
    return queue_deserialize(queue_getClient()->lPop(queue_getKey($name)));
}

function queue_createJob(string $name, $data) {
    return queue_getClient()->rPush(queue_getKey($name), queue_serialize($data));
}

function queue_getKey(string $name): string {
    return 'queue_' . $name;
}

function queue_deserialize(string $serialized) {
    return unserialize($serialized, ['allowed_classes' => []]);
}

function queue_serialize($data): string {
    return serialize($data);
}
