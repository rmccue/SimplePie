<?php

class SimplePie_Unit_Test2_Group extends Unit_Test2_Group {}

class SimplePie_Unit_Test2 extends Unit_Test2 {}

class SimplePie_Feed_Test extends SimplePie_Unit_Test2
{
	function feed()
	{
		$feed = new SimplePie();
		$feed->set_raw_data($this->data);
		$feed->enable_cache(false);
		$feed->init();
		return $feed;
	}
}

class SimplePie_Feed_Author_Test extends SimplePie_Feed_Test
{
	function author()
	{
		$feed = $this->feed();
		if ($author = $item->get_author())
		{
			return $author;
		}

		return false;
	}
}

class SimplePie_First_Item_Test extends SimplePie_Feed_Test
{
	function first_item()
	{
		$feed = $this->feed();
		if ($item = $feed->get_item(0))
		{
			return $item;
		}

		return false;
	}
}

class SimplePie_First_Item_Contributor_Test extends SimplePie_First_Item_Test
{
	function contributor()
	{
		if ($item = $this->first_item())
		{
			if ($contributor = $item->get_contributor())
			{
				return $contributor;
			}
		}
		return false;
	}
}

class SimplePie_First_Item_Content_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_content();
		}
	}
}

class SimplePie_First_Item_Contributor_Name_Test extends SimplePie_First_Item_Contributor_Test
{
	function test()
	{
		if ($contributor = $this->contributor())
		{
			$this->result = $contributor->get_name();
		}
	}
}

class SimplePie_First_Item_Date_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_date('U');
		}
	}
}

class SimplePie_First_Item_Description_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_description();
		}
	}
}

class SimplePie_First_Item_ID_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_id();
		}
	}
}

class SimplePie_First_Item_Latitude_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_latitude();
		}
	}
}

class SimplePie_First_Item_Longitude_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_longitude();
		}
	}
}

class SimplePie_First_Item_Permalink_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_permalink();
		}
	}
}

class SimplePie_First_Item_Title_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			$this->result = $item->get_title();
		}
	}
}

class SimplePie_iTunesRSS_Channel_Block_Test extends SimplePie_First_Item_Test
{
	function test()
	{
		if ($item = $this->first_item())
		{
			if ($enclosure = $item->get_enclosure())
			{
				if ($restriction = $enclosure->get_restriction())
				{
					$this->result = $restriction->get_relationship();
					return;
				}
			}
		}
		$this->result = false;
	}
}

?>
