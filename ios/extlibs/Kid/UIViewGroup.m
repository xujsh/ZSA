//
//  UIViewGroup.m
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-14.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UIViewGroup.h"

@implementation UIViewGroup
@synthesize itemList;

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self)
    {
        // Initialization code
    }
    return self;
}

+(id)initWithUIView:(UIView *) item, ...
{
	va_list args;
	va_start(args,item);
    
	id ret = [self menuWithItems:item vaList:args];
    
	va_end(args);
	
	return ret;
}


+(id) menuWithItems: (UIView *) item vaList: (va_list) args
{
	NSMutableArray *array = nil;
	if(item)
    {
		array = [NSMutableArray arrayWithObject:item];
        UIView *i = va_arg(args, UIView*);
		while(i)
        {
			[array addObject:i];
            //NSLog(@"aaaa");
			i = va_arg(args, UIView*);
            
		}
	}
	
	return [[[self alloc] initWithArray:array] autorelease];
}

-(id) initWithArray:(NSArray *)arrayOfItems
{
	if( (self=[super init]) )
    {
        int itemTag = 0;
        float itemWidth = 0;
        float itemHeigth = 0;
        self.itemList = arrayOfItems;
        for (UIView *item in arrayOfItems)
        {
            item.tag = itemTag;
            //[item addVelueChangeDelegate:self];
            [self addSubview:item];
            itemTag++;
            float nowWidth = item.bounds.size.width;
            float nowHeight = item.bounds.size.height;
            if(nowWidth > itemWidth)
            {
                itemWidth = nowWidth;
            }
            if(nowHeight > itemHeigth)
            {
                itemHeigth = nowHeight;
            }
            
        }
        //增加 set frame
        [self setSelfFrameByWidth:itemWidth ByHeight:itemHeigth];
        [self didCreateViewComplete];
    }
    return self;
}

-(void) didCreateViewComplete
{
    
}

-(void) alignItemsVerticallyWithPadding:(float) padding
{
    float width = 0;
    float height = -padding;
    UIView *item;
    for (item in self.itemList)
    {
        height += item.bounds.size.height + padding;
        width = item.bounds.size.width;
    }
    
    float y = 0;//- width / 2.0f;
    for (int i = 0; i < [itemList count]; i++)
    {
        item = [itemList objectAtIndex:i];
		CGSize itemSize = item.bounds.size;
		//[item setPosition:ccp(x + itemSize.width * item.scaleX / 2.0f, 0)];
        //NSLog(@"itemSize.width is: %f", itemSize.width);
        [item setFrame:CGRectMake(0, (y + (itemSize.height * i)), itemSize.width, itemSize.height)];
		//x += itemSize.width + padding;
        y += padding;
	}
    
    [self setSelfFrameByWidth:width ByHeight:height];
}

-(void) alignItemsHorizontallyWithPadding: (float) padding
{
    float width = -padding;
    float height = 0;
    UIView *item;
    for (item in self.itemList)
    {
        width += item.bounds.size.width + padding;
        height = item.bounds.size.height;
    }
	float x = 0;//- width / 2.0f;
    for (int i = 0; i < [itemList count]; i++)
    {
        item = [itemList objectAtIndex:i];
		CGSize itemSize = item.bounds.size;
		//[item setPosition:ccp(x + itemSize.width * item.scaleX / 2.0f, 0)];
        //NSLog(@"itemSize.width is: %f", itemSize.width);
        [item setFrame:CGRectMake((x + (itemSize.width * i)), 0, itemSize.width, itemSize.height)];
		//x += itemSize.width + padding;
        x += padding;
	}
    
    [self setSelfFrameByWidth:width ByHeight:height];
}

- (void) setSelfFrameByWidth:(float) setW ByHeight:(float) setH
{
    CGRect frame = CGRectMake(self.frame.origin.x, self.frame.origin.y, setW, setH);
    [self setFrame:frame];
}

-(void) showViewByIndex:(int)index
{
    int length = [self.itemList count];
    if(index < length)
    {
        for (int i = 0; i < length; i++)
        {
            UIView *item = [self.itemList objectAtIndex:i];
            if (i == index)
            {
                [item setHidden:NO];
            }
            else
            {
                [item setHidden:YES];
            }
        }
    }
}

/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
