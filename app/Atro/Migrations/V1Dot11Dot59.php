<?php
/*
 * AtroCore Software
 *
 * This source file is available under GNU General Public License version 3 (GPLv3).
 * Full copyright and license information is available in LICENSE.txt, located in the root directory.
 *
 * @copyright  Copyright (c) AtroCore GmbH (https://www.atrocore.com)
 * @license    GPLv3 (https://www.gnu.org/licenses/)
 */

namespace Atro\Migrations;

use Atro\Core\Exceptions\Error;
use Atro\Core\Migration\Base;
use Atro\Core\Templates\Repositories\ReferenceData;
use Atro\Core\Utils\Util;

class V1Dot11Dot59 extends Base
{
    public function getMigrationDateTime(): ?\DateTime
    {
        return new \DateTime('2024-12-09 14:00:00');
    }

    public function up(): void
    {
        if($this->isPgSQL()) {
            $this->exec("CREATE TABLE bookmark (id VARCHAR(36) NOT NULL, deleted BOOLEAN DEFAULT 'false', entity_type VARCHAR(255) DEFAULT NULL, entity_id VARCHAR(255) DEFAULT NULL, user_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id));");
            $this->exec("CREATE UNIQUE INDEX IDX_BOOKMARK_UNIQUE_BOOKMARK ON bookmark (deleted, entity_type, entity_id, user_id)");
        }else{
            $this->exec("CREATE TABLE bookmark (id VARCHAR(36) NOT NULL, deleted TINYINT(1) DEFAULT '0', entity_type VARCHAR(255) DEFAULT NULL, user_id VARCHAR(255) DEFAULT NULL, entity_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX IDX_BOOKMARK_UNIQUE_BOOKMARK(deleted, entity_type, entity_id, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;");
        }
    }

    public function down(): void
    {
    }

    protected function exec(string $query): void
    {
        try {
            $this->getPDO()->exec($query);
        } catch (\Throwable $e) {
        }
    }
}
