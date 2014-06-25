//
//  UIViewGroup.h
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-14.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIViewGroup : UIView
{
    NSArray *itemList;
}


@property (nonatomic, retain) NSArray *itemList;
//@property (assign) int groupType;
//@property (nonatomic, assign) id<UICheckBoxGroupDelegate> myDelegate;


+(id) initWithUIView:(UIView *) item, ... NS_REQUIRES_NIL_TERMINATION;
+(id) menuWithItems: (UIView *) item vaList: (va_list) args;
-(void) alignItemsVerticallyWithPadding:(float) padding;
-(void) alignItemsHorizontallyWithPadding: (float) padding;
-(void) showViewByIndex:(int)index;
-(void) didCreateViewComplete;
@end
